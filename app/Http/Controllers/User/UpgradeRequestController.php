<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\UpgradeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UpgradeRequestController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $subscriptions = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $plans = Plan::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $level1Games = Game::query()
            ->where('status', 'active')
            ->where('level', 1)
            ->orderBy('name')
            ->get()
            ->map(fn (Game $game) => [
                'id' => $game->id,
                'name' => $game->name,
                'cover_url' => $game->cover_url,
                'level' => $game->level,
            ])
            ->values();

        $otherGames = Game::query()
            ->where('status', 'active')
            ->where('level', '!=', 1)
            ->orderBy('name')
            ->get()
            ->map(fn (Game $game) => [
                'id' => $game->id,
                'name' => $game->name,
                'cover_url' => $game->cover_url,
                'level' => $game->level,
            ])
            ->values();

        $requests = UpgradeRequest::with(['subscription.plan', 'requestedPlan'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $statusMap = [
            UpgradeRequest::STATUS_PENDING => 'در انتظار تایید مدیر',
            UpgradeRequest::STATUS_REJECTED => 'رد شده',
            UpgradeRequest::STATUS_DONE => 'انجام شده',
        ];

        $planMetaById = $plans->mapWithKeys(function (Plan $plan) {
            $durations = collect($plan->durations ?? [])
                ->map(fn ($duration) => (int) $duration)
                ->filter(fn ($duration) => $duration > 0)
                ->values()
                ->all();

            return [
                $plan->id => [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'level1_selection' => (int) ($plan->level1_selection ?? 0),
                    'concurrent_games' => (int) ($plan->concurrent_games ?? 0),
                    'durations' => $durations,
                    'max_price' => $this->calculatePlanMaxPrice($plan),
                ],
            ];
        });

        $upgradeablePlans = $subscriptions->mapWithKeys(function (Subscription $subscription) use ($planMetaById) {
            $currentPlan = $subscription->plan;
            $allowed = $planMetaById->filter(function ($meta) use ($currentPlan) {
                if ($currentPlan && $meta['id'] === $currentPlan->id) {
                    return false;
                }
                return $this->canUpgradeTo($currentPlan, null, $meta);
            })
                ->map(fn ($meta) => [
                    'id' => $meta['id'],
                    'name' => $meta['name'],
                    'level1_selection' => $meta['level1_selection'],
                    'concurrent_games' => $meta['concurrent_games'],
                ])
                ->values();

            return [$subscription->id => $allowed];
        });

        return view('user.upgrade_requests', compact(
            'subscriptions',
            'plans',
            'level1Games',
            'otherGames',
            'requests',
            'statusMap',
            'planMetaById',
            'upgradeablePlans'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        Validator::make($request->all(), [
            'subscription_id' => ['required', 'integer', 'exists:subscriptions,id'],
            'requested_plan_id' => ['required', 'integer', 'exists:plans,id'],
            'requested_duration' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'subscription_id.required' => 'انتخاب اشتراک الزامی است.',
            'subscription_id.exists' => 'اشتراک انتخاب شده معتبر نیست.',
            'requested_plan_id.required' => 'پلن درخواستی را مشخص کنید.',
            'requested_plan_id.exists' => 'پلن انتخاب شده معتبر نیست.',
            'requested_duration.required' => 'مدت پلن درخواستی را مشخص کنید.',
        ])->validate();

        $subscription = Subscription::where('id', $request->integer('subscription_id'))
            ->where('user_id', $user->id)
            ->firstOrFail();

        $plan = Plan::findOrFail($request->integer('requested_plan_id'));

        if (!$this->canUpgradeTo($subscription->plan, $plan)) {
            return back()->withErrors([
                'requested_plan_id' => 'پلن انتخابی قابل ارتقا برای این اشتراک نیست.',
            ])->withInput();
        }

        $requestedDuration = $request->integer('requested_duration');
        $planDurations = collect($plan->durations ?? [])
            ->map(fn ($duration) => (int) $duration)
            ->filter(fn ($duration) => $duration > 0);

        if (!$planDurations->contains($requestedDuration)) {
            return back()->withErrors([
                'requested_duration' => 'مدت انتخاب شده برای این پلن معتبر نیست.',
            ])->withInput();
        }

        $level1Count = max(0, (int) ($plan->level1_selection ?? 0));
        $totalSlots = max(0, (int) ($plan->concurrent_games ?? 0));
        $otherCount = max(0, $totalSlots - $level1Count);

        if (($level1Count + $otherCount) === 0) {
            return back()->withErrors([
                'requested_plan_id' => 'پلن انتخاب شده ظرفیت انتخاب بازی ندارد.',
            ])->withInput();
        }

        $gameRules = [];
        if ($level1Count > 0) {
            $gameRules['games.level1'] = ['required', 'array', 'size:' . $level1Count];
            $gameRules['games.level1.*'] = ['required', 'integer', Rule::exists('games', 'id')];
        } else {
            $gameRules['games.level1'] = ['nullable', 'array', 'max:0'];
        }

        if ($otherCount > 0) {
            $gameRules['games.other'] = ['required', 'array', 'size:' . $otherCount];
            $gameRules['games.other.*'] = ['required', 'integer', Rule::exists('games', 'id')];
        } else {
            $gameRules['games.other'] = ['nullable', 'array', 'max:0'];
        }

        $gameMessages = [
            'games.level1.required' => 'انتخاب بازی‌های سطح ۱ الزامی است.',
            'games.level1.size' => "تعداد بازی‌های سطح ۱ باید دقیقاً {$level1Count} مورد باشد.",
            'games.level1.*.required' => 'تمام فیلدهای بازی سطح ۱ باید تکمیل شوند.',
            'games.other.required' => 'انتخاب سایر بازی‌ها الزامی است.',
            'games.other.size' => "تعداد سایر بازی‌ها باید دقیقاً {$otherCount} مورد باشد.",
            'games.other.*.required' => 'تمام فیلدهای سایر بازی‌ها باید تکمیل شوند.',
        ];

        Validator::make($request->all(), $gameRules, $gameMessages)->validate();

        $referenceDate = $subscription->activated_at
            ?? $subscription->purchased_at
            ?? $subscription->created_at;

        if ($referenceDate && $referenceDate->diffInDays(now()) >= 30) {
            return back()->withErrors([
                'subscription_id' => 'از شروع این اشتراک بیش از یک ماه گذشته است و امکان ثبت درخواست ارتقا وجود ندارد.',
            ])->withInput();
        }

        $level1GameIds = $level1Count > 0 ? array_map('intval', $request->input('games.level1', [])) : [];
        $otherGameIds = $otherCount > 0 ? array_map('intval', $request->input('games.other', [])) : [];

        $allGameIds = array_merge($level1GameIds, $otherGameIds);

        if (count($allGameIds) !== count(array_unique($allGameIds))) {
            return back()->withErrors([
                'games' => 'یک بازی را نمی‌توان بیش از یک بار انتخاب کرد.',
            ])->withInput();
        }

        $gamesCollection = Game::query()
            ->whereIn('id', $allGameIds)
            ->get(['id', 'name', 'level']);

        if ($gamesCollection->count() !== count($allGameIds)) {
            return back()->withErrors([
                'games' => 'برخی از بازی‌های انتخاب شده معتبر نیستند.',
            ])->withInput();
        }

        $level1Valid = $gamesCollection
            ->whereIn('id', $level1GameIds)
            ->every(fn ($g) => (int) $g->level === 1);

        $otherValid = $gamesCollection
            ->whereIn('id', $otherGameIds)
            ->every(fn ($g) => (int) $g->level !== 1);

        if (!$level1Valid || !$otherValid) {
            return back()->withErrors([
                'games' => 'بازه سطح بازی‌ها با ظرفیت پلن انتخابی هماهنگ نیست.',
            ])->withInput();
        }

        $selectedGames = [];
        foreach ($level1GameIds as $gameId) {
            $selectedGames[] = $gamesCollection->firstWhere('id', $gameId)?->name;
        }
        foreach ($otherGameIds as $gameId) {
            $selectedGames[] = $gamesCollection->firstWhere('id', $gameId)?->name;
        }

        $requestNumber = $this->generateRequestNumber();

        UpgradeRequest::create([
            'request_number' => $requestNumber,
            'user_id' => $user->id,
            'user_name' => $user->name ?? $user->phone ?? 'کاربر',
            'subscription_id' => $subscription->id,
            'requested_plan_id' => $plan->id,
            'requested_duration' => $requestedDuration,
            'selected_games' => $selectedGames ?: null,
            'selected_options' => null,
            'description' => $request->input('description'),
            'status' => UpgradeRequest::STATUS_PENDING,
        ]);

        return back()->with('success', 'درخواست ارتقا با موفقیت ثبت شد.');
    }

    protected function generateRequestNumber(): string
    {
        do {
            $number = 'UP-' . now()->format('ymd') . '-' . Str::upper(Str::random(4));
        } while (UpgradeRequest::where('request_number', $number)->exists());

        return $number;
    }

    protected function calculatePlanMaxPrice(?Plan $plan): int
    {
        if (!$plan) {
            return 0;
        }

        $prices = $plan->prices ?? [];
        if (is_array($prices)) {
            $values = array_filter(array_map(static fn ($price) => is_numeric($price) ? (int) $price : (int) filter_var($price, FILTER_SANITIZE_NUMBER_INT), $prices), static fn ($value) => $value > 0);
            return !empty($values) ? max($values) : 0;
        }

        if (is_numeric($prices)) {
            return (int) $prices;
        }

        return 0;
    }

    protected function canUpgradeTo(?Plan $currentPlan, ?Plan $targetPlan = null, ?array $targetMeta = null): bool
    {
        if (!$targetPlan && !$targetMeta) {
            return false;
        }

        if ($currentPlan && $targetPlan && $targetPlan->id === $currentPlan->id) {
            return false;
        }

        $currentPrice = $this->calculatePlanMaxPrice($currentPlan);
        $targetPrice = $targetPlan
            ? $this->calculatePlanMaxPrice($targetPlan)
            : ($targetMeta['max_price'] ?? 0);

        $currentConcurrent = (int) ($currentPlan->concurrent_games ?? 0);
        $targetConcurrent = $targetPlan
            ? (int) ($targetPlan->concurrent_games ?? 0)
            : (int) ($targetMeta['concurrent_games'] ?? 0);

        return $targetPrice > $currentPrice && $targetConcurrent >= $currentConcurrent;
    }
}
