<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $user = Auth::user();
        $code = trim($request->input('code'));
        $price = floatval($request->input('price')); // مبلغ فعلی فاکتور

        $coupon = Coupon::where('code', $code)->first();

        // ✅ بررسی وجود کوپن
        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'کد تخفیف وارد شده معتبر نیست.',
            ]);
        }

        // ✅ بررسی فعال بودن
        if (!$coupon->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'این کد تخفیف در حال حاضر غیرفعال است.',
            ]);
        }

        // ✅ بررسی انقضا
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json([
                'status' => 'error',
                'message' => 'کد تخفیف منقضی شده است.',
            ]);
        }

        // ✅ بررسی محدودیت تعداد استفاده
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'status' => 'error',
                'message' => 'ظرفیت استفاده از این کد تخفیف به پایان رسیده است.',
            ]);
        }

        // ✅ بررسی اختصاص کاربر
        if ($coupon->user_id && $coupon->user_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'این کد تخفیف مخصوص حساب کاربری دیگری است.',
            ]);
        }

        // ✅ محاسبه تخفیف
        $discountAmount = 0;
        if ($coupon->discount_type === 'percent') {
            $discountAmount = ($price * ($coupon->amount / 100));
        } else {
            $discountAmount = $coupon->amount;
        }

        // اگر تخفیف از مبلغ فاکتور بیشتر بود، اصلاح کن
        if ($discountAmount > $price) {
            $discountAmount = $price;
        }

        $finalPrice = max(0, $price - $discountAmount);

        // ❌ هنوز پرداخت انجام نشده، پس افزایش استفاده انجام نشود
        // $coupon->increment('used_count');

        return response()->json([
            'status' => 'success',
            'message' => 'کد تخفیف با موفقیت اعمال شد.',
            'discountAmount' => round($discountAmount),
            'finalPrice' => round($finalPrice),
        ]);
    }
}
