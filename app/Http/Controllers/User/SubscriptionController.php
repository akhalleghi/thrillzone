<?php

namespace App\Http\Controllers\User;

use App\Helpers\SmsHelper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Game;
use App\Models\Subscription;
use App\Models\SwapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $subscriptions = Subscription::query()
            ->with(['plan'])
            ->where('user_id', $user->id)
            ->latest('purchased_at')
            ->latest('created_at')
            ->get();

        $level1Games = Game::query()
            ->where('status', 'active')
            ->where('level', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'cover', 'level']);

        $otherGames = Game::query()
            ->where('status', 'active')
            ->where('level', '!=', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'cover', 'level']);

        $availableBookings = Booking::query()
            ->where(function ($q) use ($user) {
                $q->where('status', 'available')
                  ->orWhere(fn ($qr) => $qr->where('status', 'reserved')->where('user_id', $user->id));
            })
            ->orderBy('date')
            ->orderBy('start_time')
            ->get(['id', 'date', 'start_time', 'end_time', 'status', 'user_id', 'day_of_week']);

        $pendingSwapRequests = SwapRequest::query()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->pluck('subscription_id')
            ->all();

        return view('user.subscriptions', compact(
            'subscriptions',
            'level1Games',
            'otherGames',
            'availableBookings',
            'pendingSwapRequests'
        ));
    }

    public function saveSelection(Request $request, Subscription $subscription)
    {
        $user = $request->user();

        if ($subscription->user_id !== $user->id) {
            abort(403);
        }

        $subscription->loadMissing('plan');
        $plan = $subscription->plan;

        if (!$plan) {
            return back()->with('error', 'پلن این اشتراک موجود نیست.')->withInput();
        }

        $mode = $request->input('mode', 'initial');
        if (!in_array($mode, ['initial', 'swap'], true)) {
            return back()->with('error', 'حالت انتخاب نامعتبر است.')->withInput();
        }

        $level1Count = max(0, (int) $plan->level1_selection);
        $totalSlots  = max(0, (int) $plan->concurrent_games);
        $otherCount  = max(0, $totalSlots - $level1Count);

        if ($mode === 'initial') {
            if ($subscription->has_selected_games) {
                return back()->with('error', 'بازی‌های این اشتراک قبلاً ثبت شده‌اند.')->withInput();
            }
        } else {
            if ($subscription->status !== 'active') {
                return back()->with('error', 'برای درخواست تعویض، اشتراک باید فعال باشد.')->withInput();
            }

            if ($subscription->next_swap_at && $subscription->next_swap_at->isFuture()) {
                return back()->with('error', 'هنوز زمان درخواست تعویض بازی نرسیده است.')->withInput();
            }

            $hasPendingSwap = SwapRequest::query()
                ->where('subscription_id', $subscription->id)
                ->where('status', 'pending')
                ->exists();

            if ($hasPendingSwap) {
                return back()->with('error', 'درخواست تعویض قبلاً ثبت شده و در انتظار بررسی است.')->withInput();
            }
        }

        $rules = [];

        if ($mode === 'initial') {
            $rules['booking_id'] = [
                'required',
                Rule::exists('bookings', 'id'),
            ];
        } else {
            $rules['booking_id'] = [
                'nullable',
                'integer',
                Rule::exists('bookings', 'id'),
            ];
        }

        if ($level1Count > 0) {
            $rules['games.level1'] = ['required', 'array', 'size:' . $level1Count];
            $rules['games.level1.*'] = ['required', 'integer', Rule::exists('games', 'id')];
        } else {
            $rules['games.level1'] = ['nullable', 'array', 'max:0'];
        }

        if ($otherCount > 0) {
            $rules['games.other'] = ['required', 'array', 'size:' . $otherCount];
            $rules['games.other.*'] = ['required', 'integer', Rule::exists('games', 'id')];
        } else {
            $rules['games.other'] = ['nullable', 'array', 'max:0'];
        }

        $validator = Validator::make($request->all(), $rules, [
            'booking_id.required' => 'انتخاب زمان رزرو الزامی است.',
            'booking_id.exists' => 'زمان انتخاب‌شده معتبر نیست.',
            'games.level1.required' => 'بازی‌های سطح یک را انتخاب کنید.',
            'games.level1.size' => 'دقیقاً :size بازی سطح یک باید انتخاب شود.',
            'games.other.required' => 'بازی‌های دیگر را انتخاب کنید.',
            'games.other.size' => 'دقیقاً :size بازی از سایر سطوح باید انتخاب شود.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $level1GameIds = $level1Count > 0 ? array_map('intval', $request->input('games.level1', [])) : [];
        $otherGameIds  = $otherCount > 0 ? array_map('intval', $request->input('games.other', [])) : [];

        $allGameIds = array_merge($level1GameIds, $otherGameIds);
        if (count($allGameIds) !== count(array_unique($allGameIds))) {
            return back()->with('error', 'انتخاب بازی تکراری مجاز نیست.')->withInput();
        }

        $games = Game::query()
            ->whereIn('id', $allGameIds)
            ->get(['id', 'name', 'level']);

        if ($games->count() !== count($allGameIds)) {
            return back()->with('error', 'برخی از بازی‌های انتخاب‌شده یافت نشدند.')->withInput();
        }

        $level1Valid = $games->whereIn('id', $level1GameIds)->every(fn ($g) => (int) $g->level === 1);
        $otherValid  = $games->whereIn('id', $otherGameIds)->every(fn ($g) => (int) $g->level !== 1);

        if (!$level1Valid || !$otherValid) {
            return back()->with('error', 'سطح بازی‌های انتخاب‌شده با محدودیت پلن سازگار نیست.')->withInput();
        }

        $selectedGameNames = [];
        foreach ($level1GameIds as $id) {
            $selectedGameNames[] = (string) $games->firstWhere('id', $id)?->name;
        }
        foreach ($otherGameIds as $id) {
            $selectedGameNames[] = (string) $games->firstWhere('id', $id)?->name;
        }

        if (in_array(null, $selectedGameNames, true) || in_array('', $selectedGameNames, true)) {
            return back()->with('error', 'نام برخی بازی‌ها در دسترس نیست.')->withInput();
        }

        try {
            DB::transaction(function () use ($subscription, $mode, $user, $selectedGameNames, $request) {
                if ($mode === 'initial') {
                    $bookingId = (int) $request->input('booking_id');

                    /** @var \App\Models\Booking|null $booking */
                    $booking = Booking::query()
                        ->lockForUpdate()
                        ->find($bookingId);

                    if (!$booking) {
                        throw new \RuntimeException('زمان انتخاب‌شده وجود ندارد.');
                    }

                    $ownedByUser = (int) $booking->user_id === $user->id;
                    $isFreeSlot  = $booking->status === 'available';

                    if (!$isFreeSlot && !$ownedByUser) {
                        throw new \RuntimeException('این بازه زمانی دیگر در دسترس نیست.');
                    }

                    $bookingDateTime = Carbon::parse($booking->date)
                        ->setTimeFromTimeString($booking->start_time);

                    $booking->status = 'reserved';
                    $booking->user_id = $user->id;
                    $booking->save();

                    $subscription->active_games = array_values($selectedGameNames);
                    $subscription->requested_at = $bookingDateTime;
                    $subscription->games_selected_at = now();
                    $subscription->save();
                } else {
                    SwapRequest::query()->create([
                        'subscription_id' => $subscription->id,
                        'user_id'         => $user->id,
                        'requested_games' => array_values($selectedGameNames),
                        'status'          => 'pending',
                    ]);

                    $subscription->requested_at = now();
                    $subscription->next_swap_at = now()->addDays($subscription->swap_every_days ?? 30);
                    $subscription->save();
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', $e->getMessage())->withInput();
        }

        if ($mode === 'initial') {
            $this->sendSelectionSuccessSms($user, $subscription);
        }

        $message = $mode === 'initial'
            ? 'بازی‌ها با موفقیت ثبت شدند و منتظر تأیید پشتیبانی است.'
            : 'درخواست تعویض بازی ثبت شد و پس از تأیید اعمال می‌گردد.';

        return back()->with('success', $message);
    }

    private function sendSelectionSuccessSms($user, Subscription $subscription): void
    {
        $mobile = $user->phone
            ?? $user->mobile
            ?? $user->cellphone
            ?? $user->contact_number
            ?? null;

        if (!$mobile) {
            return;
        }

        $fullName = trim(
            $user->name
            ?? $user->full_name
            ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))
            ?? ''
        );

        if ($fullName === '') {
            $fullName = 'دوست عزیز';
        }

        $message = "🎮 {$fullName} عزیز\n"
            . "بازی‌های شما با موفقیت ثبت شد! ✅\n"
            . "لطفاً در زمان ارتباط با کارشناسان انتخاب شده، حتماً کنار دستگاه خود حضورداشته باشید.\n"
            . "⚡️ منطقه هیجان";

        try {
            SmsHelper::sendMessage($mobile, $message, [
                'user_id'         => $user->id ?? null,
                'transaction_id'  => null,
                'subscription_id' => $subscription->id ?? null,
                'purpose'         => 'subscription_selection_success',
                'track_id'        => null,
                'gateway'         => 'subscription_flow',
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
