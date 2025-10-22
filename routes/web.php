<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| مسیرهای احراز هویت کاربر (ورود با شماره موبایل)
|--------------------------------------------------------------------------
*/

// صفحه لاگین
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

// مسیر دوم برای سازگاری با auth.login
Route::get('/auth/login', function () {
    return redirect()->route('login');
})->middleware('guest')->name('auth.login');

// ارسال کد تایید
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('auth.send_otp');

// بررسی کد تایید
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify_otp');

// ارسال مجدد کد (دارای محدودیت زمانی)
Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resend_otp');

// دکمه "تغییر شماره" → ریست سشن
Route::get('/reset-otp', [AuthController::class, 'resetOtp'])->name('auth.reset');


/*
|--------------------------------------------------------------------------
| مسیرهای محافظت‌شده (فقط برای کاربران واردشده)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // داشبورد کاربر
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // صفحه سوالات متداول
    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');

    // خروج از حساب
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login')->with('success', 'شما با موفقیت خارج شدید.');
    })->name('logout');
});


/*
|--------------------------------------------------------------------------
| مسیر خانه (صفحه اصلی سایت)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // فقط صفحه index.blade.php را نمایش بده
    return view('index');
})->name('home');
