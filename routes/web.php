<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SwapRequestController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SmsLogController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\SubscriptionController as UserSubscriptionController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\User\GameController as UserGameController;
use App\Models\Game;


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

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // داشبورد کاربر
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // روت بررسی کد تخفیف
    Route::post('/apply-coupon', [\App\Http\Controllers\User\CouponController::class, 'apply'])
    ->name('apply_coupon');

    // روت های درگاه پرداخت
    Route::post('/payment/start', [PaymentController::class, 'start'])->name('payment.start');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');


    // صفحات دیگر هم می‌تونی اینجا اضافه کنی
    Route::get('/games', [UserGameController::class, 'index'])->name('games');
    // Route::get('/wallet', fn() => view('user.wallet'))->name('wallet');
    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions');
    // Route::get('/profile', fn() => view('user.profile'))->name('profile');
    Route::get('/subscriptions', [UserSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/{subscription}/selection', [UserSubscriptionController::class, 'saveSelection'])
        ->name('subscriptions.selection');

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
    // لیست بازی‌های سطح یک فعال را برای صفحه اصلی می‌آوریم
    $levelOneGames = Game::query()
        ->where('level', 1)
        ->where('status', 'active')
        ->latest()
        ->get();

    return view('index', compact('levelOneGames'));
})->name('home');

Route::get('/tutorial', function () {return view('video');})->name('tutorial');
Route::get('/faq', function () {return view('faq');})->name('faq');
Route::get('/about', function () {return view('about');})->name('about');





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
        Route::get('/sms-logs', [SmsLogController::class, 'index'])->name('sms_logs.index');


        // 💳 اشتراک ها
        // لیست اشتراک‌ها
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');

        // اقدامات سریع روی اشتراک
        Route::post('/subscriptions/{subscription}/activate', [SubscriptionController::class, 'activate'])
            ->name('subscriptions.activate');

        Route::post('/subscriptions/{subscription}/finish', [SubscriptionController::class, 'finish'])
            ->name('subscriptions.finish');

        // نمایش رسید/جزئیات
        Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])
            ->name('subscriptions.show'); // برای مودال/صفحه جزئیات


        // 🔁 درخواست تعویض
        Route::get('/swap-requests', [SwapRequestController::class, 'index'])->name('swap_requests.index');
        Route::post('/swap-requests/{swapRequest}/done', [SwapRequestController::class, 'markDone'])->name('swap_requests.done');

        // ⌚ مدیریت نوبت دهی
        Route::get('/bookings', [BookingController::class,'index'])->name('bookings.index');
        Route::post('/bookings', [BookingController::class,'store'])->name('bookings.store');
        Route::delete('/bookings/{booking}', [BookingController::class,'destroy'])->name('bookings.destroy'); 

        //  مدیریت بن های تخفیف
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);


        // ⚙️ تنظیمات
        Route::get('/settings', fn() => view('admin.settings'))->name('settings');

        // 🚪 خروج
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
