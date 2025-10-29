<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $status = $request->get('status', '');

        $coupons = Coupon::query()
            ->with('user')
            ->when($q, fn($qr) => $qr->where('code', 'like', "%{$q}%"))
            ->when($status === 'active', fn($qr) => $qr->where('is_active', true))
            ->when($status === 'inactive', fn($qr) => $qr->where('is_active', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.coupons', compact('coupons', 'q', 'status'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'code'           => 'required|string|max:50|unique:coupons,code',
        'type'           => 'required|in:public,user_specific',
        'user_id'        => 'nullable|exists:users,id',
        'amount'         => 'required|numeric|min:0',
        'discount_type'  => 'required|in:percent,fixed',
        'usage_limit'    => 'required|integer|min:1',
        'expires_at'     => 'nullable|string',
    ]);

    // ✅ تبدیل اعداد فارسی به انگلیسی و تاریخ شمسی به میلادی
    if (!empty($data['expires_at'])) {
        $data['expires_at'] = $this->convertJalaliToCarbon($data['expires_at']);
    }

    Coupon::create($data);

    return back()->with('success', 'کد تخفیف با موفقیت ایجاد شد.');
}

public function update(Request $request, Coupon $coupon)
{
    $data = $request->validate([
        'code'           => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
        'type'           => 'required|in:public,user_specific',
        'user_id'        => 'nullable|exists:users,id',
        'amount'         => 'required|numeric|min:0',
        'discount_type'  => 'required|in:percent,fixed',
        'usage_limit'    => 'required|integer|min:1',
        'expires_at'     => 'nullable|string',
        'is_active'      => 'nullable|boolean',
    ]);

    if (!empty($data['expires_at'])) {
        $data['expires_at'] = $this->convertJalaliToCarbon($data['expires_at']);
    }
    
    // ✅ اگر نوع عمومی بود، کاربر خاص نباید بماند
    if ($data['type'] === 'public') {
        $data['user_id'] = null;
    }

    $coupon->update($data);

    return back()->with('success', 'کد تخفیف با موفقیت ویرایش شد.');
}

/**
 * 🔧 تابع کمکی برای تبدیل تاریخ شمسی به Carbon
 */
private function convertJalaliToCarbon(string $dateString)
{
    try {
        // تبدیل اعداد فارسی به انگلیسی
        $english = $this->convertPersianNumbers($dateString);

        // تبدیل تاریخ شمسی به میلادی (پشتیبانی از ساعت هم)
        return Jalalian::fromFormat('Y/m/d H:i', $english)->toCarbon();
    } catch (\Throwable $e) {
        Log::error('تبدیل تاریخ شمسی به میلادی با خطا مواجه شد: ' . $e->getMessage());
        return null;
    }
}

/**
 * 🔢 تابع کمکی برای تبدیل اعداد فارسی به انگلیسی
 */
private function convertPersianNumbers(string $string): string
{
    $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
    $english = range(0, 9);
    return str_replace(array_merge($persian, $arabic), array_merge($english, $english), $string);
}

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'کد تخفیف حذف شد.');
    }
}
