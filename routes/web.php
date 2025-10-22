<?php

//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\PageController;
//use App\Http\Controllers\AuthController;
//
///*
//|--------------------------------------------------------------------------
//| Web Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register web routes for your application. These
//| routes are loaded by the RouteServiceProvider and all of them will
//| be assigned to the "web" middleware group. Make something great!
//|
//*/
//
//// مسیرهای اصلی سایت با استفاده از PageController
//Route::get('/', [PageController::class, 'index']);
//Route::get('/about', [PageController::class, 'about']);
//Route::get('/faq', [PageController::class, 'faq']);
////Route::get('/login', [PageController::class, 'login']);
//Route::get('/video', [PageController::class, 'video']);
//Route::get('/packages', [PageController::class, 'packages']);
//Route::get('/admindashboard', [PageController::class, 'admindashboard']);


//Route::get('/login', function () {return view('login');});

//

//Route::get('/tutorial', function () {
//    return view('video');
//});

//Route::middleware('guest')->group(function () {
//    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
//    Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])->name('auth.send_otp');
//    Route::post('/login/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify_otp');
//    Route::get('/login/resend', [AuthController::class, 'resendOtp'])->name('auth.resend_otp');
//});
//
//
//
//Route::middleware('auth')->group(function () {
//    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
//    Route::post('/logout', function () { auth()->logout(); return redirect('/login'); })->name('logout');
//});


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| مسیرهای احراز هویت کاربر (ورود با شماره موبایل)
|--------------------------------------------------------------------------
*/

// صفحه لاگین
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');

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
| مسیرهای محافظت‌شده (فقط کاربر واردشده)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // داشبورد کاربر
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // خروج از حساب کاربری
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('auth.login')->with('success', 'شما با موفقیت خارج شدید.');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| مسیر پیش‌فرض (خانه)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});
