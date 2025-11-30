<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\UpgradeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UpgradeRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $statusMap = [
            UpgradeRequest::STATUS_PENDING => 'در انتظار بررسی',
            UpgradeRequest::STATUS_REJECTED => 'رد شده',
            UpgradeRequest::STATUS_DONE => 'تایید شده',
        ];

        $query = UpgradeRequest::with(['user', 'subscription.plan', 'requestedPlan'])
            ->latest();

        if ($status && array_key_exists($status, $statusMap)) {
            $query->where('status', $status);
        }

        $requests = $query->paginate(15);

        return view('admin.upgrade_requests', compact('requests', 'status', 'statusMap'));
    }

    public function approve(Request $request, UpgradeRequest $upgradeRequest): RedirectResponse
    {
        if ($upgradeRequest->status !== UpgradeRequest::STATUS_PENDING) {
            return back()->with('error', 'این درخواست قبلاً رسیدگی شده است.');
        }

        $subscription = Subscription::with('plan')->findOrFail($upgradeRequest->subscription_id);
        $plan = Plan::findOrFail($upgradeRequest->requested_plan_id);

        $duration = (int) ($upgradeRequest->requested_duration ?? 0);
        $allowedDurations = collect($plan->durations ?? [])->map(fn ($d) => (int) $d)->filter(fn ($d) => $d > 0);
        if ($duration <= 0 || !$allowedDurations->contains($duration)) {
            return back()->with('error', 'مدت انتخاب شده برای این پلن معتبر نیست.');
        }

        $price = $plan->priceFor($duration) ?? $subscription->price;

        DB::transaction(function () use ($upgradeRequest, $subscription, $plan, $duration, $price) {
            $now = Carbon::now();

            $subscription->plan_id = $plan->id;
            $subscription->duration_months = $duration;
            $subscription->price = $price;
            $subscription->status = 'active';
            $subscription->purchased_at = $now;
            $subscription->activated_at = $now;
            $subscription->ends_at = $now->copy()->addMonths($duration);
            $subscription->requested_at = $now;
            $subscription->games_selected_at = $now;
            $subscription->active_games = $upgradeRequest->selected_games ?? [];
            if (!$subscription->swap_every_days) {
                $subscription->swap_every_days = 30;
            }
            $subscription->next_swap_at = $now->copy()->addDays($subscription->swap_every_days);
            $subscription->save();

            $upgradeRequest->status = UpgradeRequest::STATUS_DONE;
            $upgradeRequest->save();
        });

        return back()->with('success', 'درخواست ارتقا تایید و اشتراک به‌روزرسانی شد.');
    }

    public function reject(Request $request, UpgradeRequest $upgradeRequest): RedirectResponse
    {
        if ($upgradeRequest->status !== UpgradeRequest::STATUS_PENDING) {
            return back()->with('error', 'این درخواست قبلاً رسیدگی شده است.');
        }

        $upgradeRequest->status = UpgradeRequest::STATUS_REJECTED;
        $upgradeRequest->save();

        return back()->with('success', 'درخواست ارتقا رد شد.');
    }
}
