<?php



namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Coupon;
use App\Helpers\SmsHelper; // 🟢 برای ارسال پیامک
use Illuminate\Support\Str;

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
            'months'      => $months, // 👈 ذخیره مدت واقعی
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
            ->with('success', 'این تراکنش قبلاً تایید شده است.');
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

    $resultCode = (int)($verify['result'] ?? 0);
    $refNumber  = $verify['refNumber'] ?? null;

    // ✅ پرداخت موفق
    if ($resultCode === 100) {
        $txn->update([
            'status'   => 'success',
            'ref_code' => $refNumber,
            'paid_at'  => now(),
        ]);

        $plan = Plan::find($txn->plan_id);
        if (!$plan) {
            return redirect()->route('user.dashboard')
                ->with('error', 'پلن مربوط به این تراکنش یافت نشد.');
        }

        $months = (int) ($txn->months ?? 1);
        if ($months <= 0) $months = 1;

        $price = (int) $txn->amount;
        $swapEveryDays = $this->parseSwapLimitToDays($plan->swap_limit);

        $subscription = Subscription::create([
            'user_id'          => $txn->user_id,
            'plan_id'          => $plan->id,
            'duration_months'  => $months,
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
            if ($coupon) $coupon->increment('used_count');
        }

        // ✅ پیامک موفق
        $this->sendPaymentSms($txn, 'success', $trackId, $subscription, $plan);

        return redirect()->route('user.dashboard')->with([
            'success'  => '✅ پرداخت با موفقیت انجام شد و اشتراک در وضعیت انتظار انتخاب بازی ثبت گردید. لطفا حداکثر تا 2 روز آینده نسبت به انتخاب بازی  ها اقدام نمایید ',
            'track_id' => $trackId,
        ]);
    }

    // ❌ پرداخت ناموفق (شامل لغو و خطای بانکی)
    $txn->update([
        'status'  => 'failed',
        'paid_at' => now(),
    ]);

    // پیامک ناموفق
    $this->sendPaymentSms($txn, 'failed', $trackId);

    $message = match($resultCode) {
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


    private function sendPaymentSms(Transaction $txn, string $status, string $trackId, Subscription $subscription = null, Plan $plan = null)
{
    $user = $txn->user ?? Auth::user();
    $mobile = $user->phone ?? $user->mobile ?? null;
    if (!$mobile) return;

    $fullName = trim($user->name ?? $user->full_name ?? 'کاربر عزیز');

    try {
        if ($status === 'success' && $subscription && $plan) {
            $msg = "🎉 {$fullName} عزیز
اشتراک «{$plan->name}» با موفقیت ثبت شد.
شماره اشتراک: {$subscription->subscription_code}

⏰لطفا حداکثر تا ۲ روز آینده از قسمت «اشتراک‌های من» بازی‌های خود را انتخاب کنید؛ تأخیر باعث کسر زمان اشتراک می‌شود.
🙏 از انتخاب شما سپاسگزاریم 💙
منطقه هیجان";
            $this->notifyAdminsAboutPurchase($subscription, $plan);
        } elseif ($status === 'failed') {
            $msg = "❌ {$fullName} عزیز
خرید شما ناموفق بود.
کد پیگیری: {$trackId}
📱 از پنل کاربری می‌توانید دوباره اقدام کنید.
منطقه هیجان";
        } else return;

        SmsHelper::sendMessage($mobile, $msg, [
            'user_id'        => $user->id ?? null,
            'transaction_id' => $txn->id ?? null,
            'subscription_id'=> $subscription->id ?? null,
            'purpose'        => $status === 'success' ? 'payment_success' : 'payment_failed',
            'track_id'       => $trackId,
            'gateway'        => 'zibal',
        ]);
    } catch (\Throwable $e) {
        Log::warning("SMS send error: " . $e->getMessage());
    }
}

    private function notifyAdminsAboutPurchase(Subscription $subscription, Plan $plan): void
    {
        $adminMobiles = ['09137640338', '09132789505'];
        $durationMonths = (int) ($subscription->duration_months ?? 0);
        $durationLabel = $durationMonths > 0
            ? $this->toPersianDigits($durationMonths) . ' ماهه'
            : 'نامشخص';

        $message = "سلام مدیر 😊🚀
سفارش با شماره اشتراک {$this->toPersianDigits($subscription->subscription_code)}
پلن انتخابی: {$plan->name}
مدت پلن: {$durationLabel}
در منطقه هیجان ثبت شد.";

        foreach ($adminMobiles as $mobile) {
            try {
                SmsHelper::sendMessage($mobile, $message, [
                    'subscription_id' => $subscription->id,
                    'plan_id'         => $plan->id,
                    'purpose'         => 'admin_purchase_alert',
                ]);
            } catch (\Throwable $e) {
                Log::warning("Admin SMS send error ({$mobile}): " . $e->getMessage());
            }
        }
    }

    private function toPersianDigits(string|int|null $value): string
    {
        $value = (string) ($value ?? '');
        $map = ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'];

        return strtr($value, $map);
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
        if ($swap === 'none') return null;
        $num = (int) preg_replace('/\D/', '', $swap);
        if ($num <= 0) return null;

        return str_ends_with($swap, 'm') ? $num * 30 : $num;
    }
}
