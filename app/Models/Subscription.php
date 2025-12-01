<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\UpgradeRequest;

class Subscription extends Model
{
    public const SELECTION_GRACE_DAYS = 2;

    protected $fillable = [
        'user_id',
        'plan_id',
        'duration_months',
        'price',
        'status',
        'purchased_at',
        'requested_at',
        'games_selected_at',
        'activated_at',
        'ends_at',
        'swap_every_days',
        'next_swap_at',
        'active_games',
        'subscription_code',
        'account_details',
    ];

    protected $casts = [
        'purchased_at'  => 'datetime',
        'requested_at'  => 'datetime',
        'games_selected_at' => 'datetime',
        'activated_at'  => 'datetime',
        'ends_at'       => 'datetime',
        'next_swap_at'  => 'datetime',
        'active_games'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function upgradeRequests()
    {
        return $this->hasMany(UpgradeRequest::class);
    }

    public function getActiveGamesListAttribute(): string
    {
        $games = $this->active_games ?? [];

        if (!is_array($games)) {
            return '-';
        }

        $games = array_values(array_filter($games, fn ($item) => $item !== null && $item !== ''));

        if (empty($games)) {
            return '-';
        }

        return implode(', ', $games);
    }

    public function getRemainingSecondsAttribute(): ?int
    {
        if ($this->status !== 'active' || !$this->ends_at) {
            return null;
        }

        $diff = $this->ends_at->diffInSeconds(now(), false);

        return $diff < 0 ? abs($diff) : 0;
    }

    public function getSwapRemainingSecondsAttribute(): ?int
    {
        if ($this->status !== 'active' || !$this->next_swap_at) {
            return null;
        }

        $diff = $this->next_swap_at->diffInSeconds(now(), false);

        return $diff < 0 ? 0 : $diff;
    }

    public function getSelectionDeadlineAttribute(): ?Carbon
    {
        $base = $this->purchased_at ?? $this->created_at;

        if (!$base) {
            return null;
        }

        return $base->copy()->addDays(self::SELECTION_GRACE_DAYS);
    }

    public function getSelectionCompletedAtAttribute(): ?Carbon
    {
        return $this->games_selected_at;
    }

    public function getSelectionRemainingSecondsAttribute(): ?int
    {
        if ($this->status !== 'waiting') {
            return null;
        }

        $deadline = $this->selection_deadline;

        if (!$deadline) {
            return null;
        }

        $diff = $deadline->diffInSeconds(now(), false);

        return $diff < 0 ? 0 : $diff;
    }

    public function getSelectionDelayDaysAttribute(): int
    {
        $deadline = $this->selection_deadline;

        if (!$deadline) {
            return 0;
        }

        if ($this->games_selected_at) {
            $reference = $this->games_selected_at;
        } elseif ($this->status === 'active') {
            $reference = $this->activated_at ?? now();
        } else {
            $reference = now();
        }

        if ($reference->lessThanOrEqualTo($deadline)) {
            return 0;
        }

        return $deadline->diffInDays($reference);
    }

    public function getSelectionOverdueDaysAttribute(): int
    {
        return $this->selection_delay_days;
    }

    public function getHasSelectedGamesAttribute(): bool
    {
        $games = $this->active_games;

        if (is_array($games)) {
            return count(array_filter($games, fn($item) => $item !== null && $item !== '')) > 0;
        }

        return !empty($games);
    }

    public function getIsWaitingReadyAttribute(): bool
    {
        return $this->status === 'waiting' && $this->has_selected_games && (bool) $this->games_selected_at;
    }

    protected static function booted(): void
    {
        static::creating(function (self $subscription): void {
            if (!empty($subscription->subscription_code)) {
                return;
            }

            do {
                $random = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $code = 'TZ-' . $random;
            } while (self::where('subscription_code', $code)->exists());

            $subscription->subscription_code = $code;
        });

        static::saving(function (self $subscription): void {
            $isWaiting = $subscription->status === 'waiting';

            $games = $subscription->active_games;
            $hasGames = is_array($games)
                ? count(array_filter($games, fn($item) => $item !== null && $item !== '')) > 0
                : !empty($games);

            if ($isWaiting && !$hasGames && $subscription->isDirty('active_games')) {
                $subscription->games_selected_at = null;
            }

            if ($isWaiting && $hasGames && !$subscription->games_selected_at && ($subscription->isDirty('active_games') || $subscription->isDirty('requested_at'))) {
                $subscription->games_selected_at = now();
            }
        });
    }
}
