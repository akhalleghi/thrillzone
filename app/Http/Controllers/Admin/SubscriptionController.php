<?php
// app/Http/Controllers/Admin/SubscriptionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\SmsHelper;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim($request->get('q',''));        // جستجو: نام/موبایل کاربر
        $status  = $request->get('status','');         // waiting|waiting_ready|active|ended
        $planId  = $request->get('plan_id','');        // فیلتر پلن
        $from    = $request->get('from','');           // تاریخ از (میلادی یا تبدیل‌شده)
        $to      = $request->get('to','');             // تاریخ تا

        $subscriptions = Subscription::query()
            ->with(['user','plan'])
            ->when($q, function($qr) use ($q){
                $qr->whereHas('user', function($u) use ($q){
                    $u->where('name','like',"%{$q}%")
                      ->orWhere('phone','like',"%{$q}%");
                });
            })
            ->when(in_array($status,['waiting','active','ended'], true), fn($qr)=>$qr->where('status',$status))
            ->when($status === 'waiting_ready', function ($qr) {
                $qr->where('status', 'waiting')
                   ->whereNotNull('games_selected_at')
                   ->whereNotNull('active_games')
                   ->whereRaw('JSON_LENGTH(active_games) > 0');
            })
            ->when($planId, fn($qr)=>$qr->where('plan_id',(int)$planId))
            ->when($from, fn($qr)=>$qr->whereDate('purchased_at','>=',$from))
            ->when($to,   fn($qr)=>$qr->whereDate('purchased_at','<=',$to))
            ->latest('purchased_at')
            ->paginate(12)
            ->withQueryString();

        $plans = Plan::query()->orderBy('name')->get(['id','name']);

        return view('admin.subscriptions', compact('subscriptions','q','status','planId','from','to','plans'));
    }

    // فعال‌سازی دستی: شروع=الان، پایان=الان+duration_months
    public function activate(Request $request, Subscription $subscription)
    {
        if ($subscription->status === 'active') {
            return back()->with('error','این اشتراک همین حالا فعال است.');
        }

        $activatedAt = now();
        $selectionDeadline    = $subscription->selection_deadline;
        $selectionCompletedAt = $subscription->games_selected_at ?? $activatedAt;
        $selectionDelayDays   = 0;

        if ($selectionDeadline && $selectionCompletedAt->greaterThan($selectionDeadline)) {
            $selectionDelayDays = $selectionDeadline->diffInDays($selectionCompletedAt);
        }

        $endsAt = (clone $activatedAt)->addMonths($subscription->duration_months);
        if ($selectionDelayDays > 0) {
            $endsAt->subDays($selectionDelayDays);

            if ($endsAt->lessThanOrEqualTo($activatedAt)) {
                $endsAt = $activatedAt->copy();
            }
        }

        // محاسبه next_swap_at از swap_every_days
        $nextSwap = null;
        if ($subscription->swap_every_days) {
            $nextSwap = (clone $activatedAt)->addDays($subscription->swap_every_days);
        }

        $subscription->update([
            'status'        => 'active',
            'activated_at'  => $activatedAt,
            'ends_at'       => $endsAt,
            'next_swap_at'  => $nextSwap,
        ]);

        $subscription->loadMissing(['user', 'plan']);

        $userName    = trim($subscription->user->name ?? 'کاربر');
        $planName    = $subscription->plan->name ?? 'اشتراک';
        $mobile      = $subscription->user->phone ?? null;
        $usableDays  = max(1, (int) $activatedAt->diffInDays($endsAt));

        if ($mobile) {
            $message = "{$userName} عزیز 📣\nاشتراک 🌟 {$planName} 🌟\nبا موفقیت فعال شد ✅\nاز امروز به مدت ⏰ {$usableDays} روز در دسترس شماست.\nاز انتخاب شما سپاسگزاریم 🙏\n💥 منطقه هیجان 💥";
            SmsHelper::sendMessage($mobile, $message);
        }

        return back()->with('success','اشتراک فعال شد.');
    }

    // خاتمه دادن دستی:
    public function finish(Request $request, Subscription $subscription)
    {
        if ($subscription->status === 'ended') {
            return back()->with('error','این اشتراک قبلاً پایان یافته است.');
        }

        $subscription->update([
            'status' => 'ended',
            'ends_at'=> now(),
        ]);

        return back()->with('success','اشتراک خاتمه یافت.');
    }

    // نمایش جزئیات/رسید
    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', compact('subscription'));
    }
}
