<?php
// app/Http/Controllers/Admin/SubscriptionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $status  = $request->get('status','');         // waiting|active|ended
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
        $endsAt = (clone $activatedAt)->addMonths($subscription->duration_months);

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
