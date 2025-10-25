<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\TransactionController;


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

Route::post('/complete-profile', [AuthController::class, 'completeProfile'])->name('auth.complete_profile');


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

//    // صفحه سوالات متداول
//    Route::get('/faq', function () {
//        return view('faq');
//    })->name('faq');

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

Route::get('/tutorial', function () {return view('video');})->name('tutorial');
Route::get('/faq', function () {return view('faq');})->name('faq');
Route::get('/about', function () {return view('about');})->name('about');


///*
//|--------------------------------------------------------------------------
//| مسیرهای پنل ادمین
//|--------------------------------------------------------------------------
//*/
//
//// گروه روت‌های پنل مدیریت
//Route::prefix('admin')->name('admin.')->group(function () {
//
//    // ورود ادمین (موقتی بدون alias)
//    Route::middleware(\App\Http\Middleware\RedirectIfAuthenticatedAdmin::class)->group(function () {
//        Route::get('login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('login');
//        Route::post('login', [App\Http\Controllers\Admin\AdminAuthController::class, 'login'])
//            ->middleware('throttle:6,1')
//            ->name('login.submit');
//    });
//
//    // صفحات محافظت‌شده (فقط وقتی لاگین است)
//    Route::middleware('auth:admin')->group(function () {
//        Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
//        Route::post('logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');
//    });
//});

/*
|--------------------------------------------------------------------------
| مسیرهای پنل مدیریت (Admin Panel)
|--------------------------------------------------------------------------
*/



//Route::prefix('admin')->name('admin.')->group(function () {
//
//    /*
//    |--------------------------------------------------------------------------
//    | مسیرهای ورود مدیر
//    |--------------------------------------------------------------------------
//    */
//    Route::middleware(\App\Http\Middleware\RedirectIfAuthenticatedAdmin::class)->group(function () {
//        // فرم ورود
//        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
//
//        // ارسال اطلاعات ورود
//        Route::post('login', [AdminAuthController::class, 'login'])
//            ->middleware('throttle:6,1')
//            ->name('login.submit');
//    });
//
//
//    /*
//    |--------------------------------------------------------------------------
//    | مسیرهای محافظت‌شده (فقط وقتی مدیر وارد شده است)
//    |--------------------------------------------------------------------------
//    */
//    Route::middleware('auth:admin')->group(function () {
//        // داشبورد اصلی
//        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
//
//        // ✅ لیست کاربران از کنترلر
//        Route::get('/users', [UserController::class, 'index'])->name('users');
//
//        // سایر صفحات (فعلاً استاتیک)
//        Route::get('/plans', fn() => view('admin.plans'))->name('plans');
//        Route::get('/finance', fn() => view('admin.finance'))->name('finance');
//        Route::get('/settings', fn() => view('admin.settings'))->name('settings');
//
//        // خروج از حساب مدیر
//        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
//    });
//});


/*
|--------------------------------------------------------------------------
| مسیرهای پنل مدیریت (Admin Panel)
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\Admin\GameController;

Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | مسیرهای ورود مدیر
    |--------------------------------------------------------------------------
    */
    Route::middleware(\App\Http\Middleware\RedirectIfAuthenticatedAdmin::class)->group(function () {
        // فرم ورود
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');

        // ارسال اطلاعات ورود
        Route::post('login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:6,1')
            ->name('login.submit');
    });


    /*
    |--------------------------------------------------------------------------
    | مسیرهای محافظت‌شده (فقط وقتی مدیر وارد شده است)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:admin')->group(function () {
        // 🏠 داشبورد
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // 👥 کاربران
        Route::get('/users', [UserController::class, 'index'])->name('users');

        // 🎮 بازی‌ها (CRUD کامل)
        Route::resource('/games', GameController::class)
            ->except(['show']) // چون صفحه show جدا نیاز نداریم
            ->names('games');

        // 📦 پلن‌ها
        Route::get('/plans', [PlanController::class, 'index'])->name('plans');
        Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
        Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');

        // 💰 امور مالی
        Route::get('/finance', [TransactionController::class, 'index'])->name('finance');

        // ⚙️ تنظیمات
        Route::get('/settings', fn() => view('admin.settings'))->name('settings');

        // 🚪 خروج
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});




