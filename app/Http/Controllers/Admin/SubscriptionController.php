<?php
// app/Http/Controllers/Admin/SubscriptionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\SmsHelper;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

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
        $level1Games = Game::query()->where('level', 1)->orderBy('name')->get(['id','name','cover']);
        $otherGames  = Game::query()->where('level','!=',1)->orderBy('name')->get(['id','name','cover']);

        return view('admin.subscriptions', compact('subscriptions','q','status','planId','from','to','plans','level1Games','otherGames'));
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
            $lines = [
                "{$userName} عزیز 📣",
                "اشتراک 🌟 {$planName} 🌟",
                "با موفقیت فعال شد ✅",
                "از امروز به مدت ⏰ {$usableDays} روز در دسترس شماست.",
            ];

            if ($selectionDelayDays > 0) {
                $lines[] = "توجه: به دلیل تأخیر در انتخاب بازی‌ها {$selectionDelayDays} روز از مدت اشتراک شما کسر شد.";
            }

            $lines[] = "از انتخاب شما سپاسگزاریم 🙏";
            $lines[] = "💥 منطقه هیجان 💥";

            SmsHelper::sendMessage(
                $mobile,
                implode("\n", $lines),
                [
                    'user_id'        => $user->id ?? null,
                    'transaction_id' => $txn->id ?? null,
                    'subscription_id'=> $subscription->id ?? null,
                    'purpose'        => 'custom_message', // یا هر نوعی مثل 'manual_send'، 'reminder'، 'otp' و غیره
                    'track_id'       => $trackId ?? null,
                    'gateway'        => 'zibal',
                ]
            );

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

    public function updateGames(Request $request, Subscription $subscription)
    {
        $subscription->loadMissing('plan');
        $plan = $subscription->plan;

        if (!$plan) {
            return back()->with('error', 'پلن این اشتراک یافت نشد.')->withInput();
        }

        $level1Count = max(0, (int) $plan->level1_selection);
        $totalSlots  = max(0, (int) $plan->concurrent_games);
        $otherCount  = max(0, $totalSlots - $level1Count);

        if ($totalSlots <= 0) {
            return back()->with('error', 'این پلن اسلات فعالی برای انتخاب بازی ندارد.')->withInput();
        }

        $rules = [];

        if ($level1Count > 0) {
            $rules['games.level1']   = ['required', 'array', 'size:' . $level1Count];
            $rules['games.level1.*'] = ['required', 'integer', Rule::exists('games', 'id')];
        } else {
            $rules['games.level1'] = ['nullable', 'array', 'max:0'];
        }

        if ($otherCount > 0) {
            $rules['games.other']   = ['required', 'array', 'size:' . $otherCount];
            $rules['games.other.*'] = ['required', 'integer', Rule::exists('games', 'id')];
        } else {
            $rules['games.other'] = ['nullable', 'array', 'max:0'];
        }

        $data = $request->validate($rules, [
            'games.level1.required' => 'انتخاب بازی‌های سطح ۱ الزامی است.',
            'games.level1.size'     => "باید دقیقاً {$level1Count} بازی سطح ۱ انتخاب شود.",
            'games.other.required'  => 'انتخاب سایر بازی‌ها الزامی است.',
            'games.other.size'      => "باید دقیقاً {$otherCount} بازی از سایر سطوح انتخاب شود.",
        ]);

        $level1Ids = $level1Count > 0 ? array_map('intval', $data['games']['level1'] ?? []) : [];
        $otherIds  = $otherCount > 0 ? array_map('intval', $data['games']['other'] ?? []) : [];

        $allGameIds = array_merge($level1Ids, $otherIds);
        if (count($allGameIds) !== count(array_unique($allGameIds))) {
            return back()->with('error', 'یک بازی را بیش از یک‌بار انتخاب کرده‌اید.')->withInput();
        }

        $games = Game::query()
            ->whereIn('id', $allGameIds)
            ->get(['id', 'name', 'level']);

        if ($games->count() !== count($allGameIds)) {
            return back()->with('error', 'یکی از بازی‌های انتخابی در سیستم یافت نشد.')->withInput();
        }

        $level1Valid = $games->whereIn('id', $level1Ids)->every(fn($g) => (int) $g->level === 1);
        $otherValid  = $games->whereIn('id', $otherIds)->every(fn($g) => (int) $g->level !== 1);

        if (!$level1Valid || !$otherValid) {
            return back()->with('error', 'بازی‌های انتخابی با سطح مورد نیاز پلن همخوانی ندارند.')->withInput();
        }

        $selectedGameNames = [];
        foreach ($level1Ids as $id) {
            $selectedGameNames[] = (string) $games->firstWhere('id', $id)?->name;
        }
        foreach ($otherIds as $id) {
            $selectedGameNames[] = (string) $games->firstWhere('id', $id)?->name;
        }

        $subscription->update([
            'active_games'      => array_values($selectedGameNames),
            'games_selected_at' => now(),
            'requested_at'      => now(),
        ]);

        return back()->with('success', 'بازی‌های اشتراک با موفقیت به‌روزرسانی شد.');
    }

    public function updateAccountDetails(Request $request, Subscription $subscription)
    {
        $data = $request->validate([
            'account_details' => ['nullable', 'string', 'max:5000'],
        ]);

        $details = isset($data['account_details']) ? trim($data['account_details']) : '';

        $subscription->update([
            'account_details' => $details !== '' ? $details : null,
        ]);

        return back()->with('success','جزئیات اکانت ذخیره شد.');
    }

    // نمایش جزئیات/رسید
    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', compact('subscription'));
    }
}
