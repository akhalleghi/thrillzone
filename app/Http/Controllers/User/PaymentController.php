<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function start(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'plan_id' => 'required|integer|exists:plans,id',
            'months'  => 'required|integer|min:1|max:24',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $planId = $validated['plan_id'];
        $months = $validated['months'];
        $code   = trim($validated['coupon_code'] ?? '');

        $plan = Plan::findOrFail($planId);
        $basePrice = (int) ($plan->prices[$months] ?? 0);
        if ($basePrice <= 0) {
            return back()->with('error', 'مدت زمان انتخابی برای این پلن معتبر نیست.');
        }

        [$finalPrice, $discountAmount, $couponModel] = $this->applyCouponServerSide($code, $basePrice, $user->id);

        $amountRial = max(1000, $finalPrice * 10); // تومان → ریال

        // ایجاد تراکنش
        $txn = Transaction::create([
            'user_id'     => $user->id,
            'plan_id'     => $plan->id,
            'amount'      => $finalPrice,
            'status'      => 'pending',
            'gateway'     => 'zibal',
            'txn_number'  => Str::upper(Str::random(10)),
            'ref_code'    => null,
            'paid_at'     => null,
            'months'      => $months, // 👈 اینجا مقدار واقعی ذخیره میشه
            'coupon_code' => $couponModel?->code,
            'discount'    => $discountAmount,
        ]);

        $callbackUrl = route('user.payment.callback', [], true);

        try {
            $response = Http::timeout(15)->post(config('zibal.base_url') . 'request', [
                'merchant'    => config('zibal.merchant'),
                'amount'      => $amountRial,
                'callbackUrl' => $callbackUrl,
                'orderId'     => (string) $txn->id,
                'description' => "خرید اشتراک {$months} ماهه - کاربر {$user->name}",
            ])->json();
        } catch (\Throwable $e) {
            Log::error('Zibal connection error: ' . $e->getMessage());
            return back()->with('error', 'خطا در ارتباط با درگاه پرداخت. لطفاً مجدداً تلاش کنید.');
        }

        if (!isset($response['result']) || (int)$response['result'] !== 100) {
            Log::warning('Zibal error response', $response);
            return back()->with('error', 'خطا در ایجاد تراکنش در درگاه زیبال.');
        }

        $trackId = $response['trackId'] ?? null;
        $txn->update(['ref_code' => $trackId]);

        return redirect()->away("https://gateway.zibal.ir/start/{$trackId}");
    }

    public function callback(Request $request)
    {
        $trackId = $request->query('trackId');
        if (!$trackId) {
            return redirect()->route('user.dashboard')
                ->with('error', 'پارامتر بازگشت نامعتبر است.');
        }

        $txn = Transaction::where('ref_code', $trackId)->first();
        if (!$txn) {
            return redirect()->route('user.dashboard')
                ->with('error', 'تراکنش یافت نشد.');
        }

        if ($txn->status === 'success') {
            return redirect()->route('user.dashboard')
                ->with('success', 'این تراکنش قبلاً تایید شده است.', 'track_id', $trackId);
        }

        try {
            $verify = Http::timeout(15)->post(config('zibal.base_url') . 'verify', [
                'merchant' => config('zibal.merchant'),
                'trackId'  => $trackId,
            ])->json();
        } catch (\Throwable $e) {
            Log::error('Zibal verify error: ' . $e->getMessage());
            return redirect()->route('user.dashboard')
                ->with('error', 'خطا در بررسی وضعیت پرداخت.');
        }

        // پرداخت موفق
        if (isset($verify['result']) && (int)$verify['result'] === 100) {
            $txn->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);

            $plan = Plan::find($txn->plan_id);
            if (!$plan) {
                return redirect()->route('user.dashboard')
                    ->with('error', 'پلن مربوط به این تراکنش یافت نشد.');
            }

            $months = (int) ($txn->months ?? 1);
            if ($months <= 0) $months = 1; // اگر به هر دلیلی صفر بود، پیش‌فرض 1 ماه

            $price = (int) $txn->amount;
            $swapEveryDays = $this->parseSwapLimitToDays($plan->swap_limit);

            Subscription::create([
                'user_id'          => $txn->user_id,
                'plan_id'          => $plan->id,
                'duration_months'  => $months, // 👈 مدت واقعی اشتراک
                'price'            => $price,
                'status'           => 'waiting',
                'purchased_at'     => now(),
                'requested_at'     => null,
                'activated_at'     => null,
                'ends_at'          => null,
                'swap_every_days'  => $swapEveryDays,
                'next_swap_at'     => null,
                'active_games'     => [],
            ]);

            if ($txn->coupon_code) {
                $coupon = Coupon::where('code', $txn->coupon_code)->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            return redirect()->route('user.dashboard')->with([
                'success'  => 'پرداخت با موفقیت انجام شد ✅ اشتراک شما در وضعیت انتظار ثبت گردید.',
                'track_id' => $trackId,
            ]);
        }

        // پرداخت ناموفق
        $txn->update(['status' => 'failed']);
        $message = match((int)($verify['result'] ?? 0)) {
            -1 => 'در انتظار پرداخت.',
            -2 => 'خطای بانکی رخ داده است.',
            -3 => 'تراکنش توسط کاربر لغو شد.',
            -4 => 'کد پیگیری معتبر نیست.',
            default => 'پرداخت ناموفق بود یا توسط شما لغو شد.',
        };

        return redirect()->route('user.dashboard')->with([
            'error' => $message,
            'track_id' => $trackId,
        ]);
    }

    private function applyCouponServerSide(?string $code, int $basePrice, int $userId): array
    {
        if (!$code) return [$basePrice, 0, null];

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) return [$basePrice, 0, null];
        if (!$coupon->is_active) return [$basePrice, 0, null];
        if ($coupon->expires_at && $coupon->expires_at->isPast()) return [$basePrice, 0, null];
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) return [$basePrice, 0, null];
        if ($coupon->user_id && (int)$coupon->user_id !== (int)$userId) return [$basePrice, 0, null];

        $discount = $coupon->discount_type === 'percent'
            ? (int) floor($basePrice * ($coupon->amount / 100))
            : (int) $coupon->amount;

        if ($discount > $basePrice) $discount = $basePrice;
        $final = max(0, $basePrice - $discount);

        return [$final, $discount, $coupon];
    }

    private function parseSwapLimitToDays(?string $swap): ?int
    {
        if (!$swap) return null;
        $num = (int) preg_replace('/\D/', '', $swap);
        if ($num <= 0) return null;

        return str_ends_with($swap, 'm') ? $num * 30 : $num;
    }
}
