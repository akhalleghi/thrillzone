<?php
//
//namespace App\Http\Controllers\Admin;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//
//class AdminAuthController extends Controller
//{
//    public function showLoginForm()
//    {
//        // اگر قبلاً لاگین است، به داشبورد بفرست
//        if (Auth::guard('admin')->check()) {
//            return redirect()->route('admin.dashboard');
//        }
//        return view('admin.auth.login');
//    }
//
//    public function login(Request $request)
//    {
//        $request->validate([
//            'username' => ['required','string','max:100'],
//            'password' => ['required','string','min:6'],
//            'remember' => ['nullable','boolean'],
//        ],[
//            'username.required' => 'نام کاربری را وارد کنید',
//            'password.required' => 'رمز عبور را وارد کنید',
//        ]);
//
//        // بررسی کپچا
//        if ((int)$request->captcha !== (int)session('captcha_sum')) {
//            return back()->withErrors(['captcha' => 'کد امنیتی اشتباه است.'])
//                ->withInput($request->only('username'));
//        }
//
//
//        $credentials = $request->only('username','password');
//        $remember    = (bool)$request->boolean('remember');
//
//        if (Auth::guard('admin')->attempt($credentials, $remember)) {
//            $request->session()->regenerate(); // جلوگیری از Session Fixation
//            return redirect()->intended(route('admin.dashboard'))
//                ->with('success','ورود موفقیت‌آمیز بود');
//        }
//
//        return back()->withErrors(['username' => 'نام کاربری یا رمز عبور اشتباه است'])
//            ->withInput($request->only('username'));
//    }
//
//    public function logout(Request $request)
//    {
//        Auth::guard('admin')->logout();
//
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
//
//        // 🔹 مسیر صحیح برای لاگین ادمین:
//        return redirect()->route('admin.login')
//            ->with('success', 'شما با موفقیت از پنل مدیریت خارج شدید.');
//    }
//
//}


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * نمایش فرم لاگین ادمین
     */
    public function showLoginForm()
    {
        // اگر قبلاً لاگین است → هدایت به داشبورد
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // هر بار که فرم باز میشه، کپچای جدید بساز
        session()->forget('captcha_sum');

        return view('admin.auth.login');
    }

    /**
     * ورود مدیر سیستم
     */
    public function login(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:6'],
            'captcha' => ['required', 'numeric'],
            'remember' => ['nullable', 'boolean'],
        ], [
            'username.required' => 'نام کاربری را وارد کنید',
            'password.required' => 'رمز عبور را وارد کنید',
            'captcha.required' => 'لطفاً کد امنیتی را وارد کنید',
            'captcha.numeric' => 'کد امنیتی باید عددی باشد',
        ]);

        // بررسی کپچا
        if ((int)$request->captcha !== (int)session('captcha_sum')) {
            // اگر اشتباه بود کپچا رو حذف کن تا دوباره ساخته شه
            session()->forget('captcha_sum');

            return back()
                ->withErrors(['captcha' => 'کد امنیتی اشتباه است.'])
                ->withInput($request->only('username'));
        }

        // پاک کردن کپچا بعد از بررسی
        session()->forget('captcha_sum');

        // تلاش برای ورود
        $credentials = $request->only('username', 'password');
        $remember = (bool)$request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate(); // جلوگیری از Session Fixation
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'ورود موفقیت‌آمیز بود');
        }

        // ورود ناموفق
        return back()
            ->withErrors(['username' => 'نام کاربری یا رمز عبور اشتباه است'])
            ->withInput($request->only('username'));
    }

    /**
     * خروج از حساب مدیر
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'شما با موفقیت از پنل مدیریت خارج شدید.');
    }
}
