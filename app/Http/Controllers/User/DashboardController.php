<?php

// namespace App\Http\Controllers\User;

// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
// use App\Models\Subscription;
// use Carbon\Carbon;
// use Morilog\Jalali\Jalalian;


// class DashboardController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();

//         // 1) تعداد پلن‌های فعال کاربر از جدول subscriptions
//         $activePlansCount = Subscription::where('user_id', $user->id)
//             ->where('status', 'active')
//             ->count();

//         // 2) سابقه عضویت (روزها) از زمان ثبت‌نام کاربر
//         // اگر ستون دیگری برای شروع عضویت داری جایگزین کن.
//         $membershipDays = floor(Carbon::parse($user->created_at)->floatDiffInDays(now()));



//         // 3) مجموع تراکنش‌های موفق (اختیاری - اگر جدول/اسامی متفاوت است، اصلاح کن)
//         $successfulTransactions = DB::table('transactions')
//             ->where('user_id', $user->id)
//             ->where('status', 'success')
//             ->sum('amount');

//         // 4) تاریخ تمدید بعدی (نمونه: نزدیک‌ترین ends_at فعال)
//         $nextRenewAt = Subscription::where('user_id', $user->id)
//             ->where('status', 'active')
//             ->whereNotNull('ends_at')
//             ->orderBy('ends_at', 'asc')
//             ->value('ends_at'); // ممکنه null برگرده

//         return view('user.dashboard', compact(
//             'activePlansCount',
//             'membershipDays',
//             'successfulTransactions',
//             'nextRenewAt'
//         ));
//     }
// }



namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Plan;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1) تعداد پلن‌های فعال کاربر
        $activePlansCount = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        // 2) سابقه عضویت (تعداد روز)
        $membershipDays = floor(Carbon::parse($user->created_at)->floatDiffInDays(now()));

        // 3) مجموع تراکنش‌های موفق
        $successfulTransactions = DB::table('transactions')
            ->where('user_id', $user->id)
            ->where('status', 'success')
            ->sum('amount');

        // 4) تاریخ تمدید بعدی (نزدیک‌ترین ends_at فعال)
        $nextRenewAt = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereNotNull('ends_at')
            ->orderBy('ends_at', 'asc')
            ->value('ends_at'); // ممکنه null برگرده

        // 5) دریافت پلن‌های فعال برای نمایش در مدال خرید اشتراک
        $plans = Plan::where('active', true)
            ->orderBy('id', 'asc')
            ->get();

        // ارسال تمام داده‌ها به ویو
        return view('user.dashboard', compact(
            'activePlansCount',
            'membershipDays',
            'successfulTransactions',
            'nextRenewAt',
            'plans'
        ));
    }
}
