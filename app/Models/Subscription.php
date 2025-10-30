<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'activated_at',
        'ends_at',
        'swap_every_days',
        'next_swap_at',
        'active_games',
        'subscription_code',
    ];

    protected $casts = [
        'purchased_at'  => 'datetime',
        'requested_at'  => 'datetime',
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

    public function getActiveGamesListAttribute(): string
    {
        $games = $this->active_games ?? [];

        if (!is_array($games) || empty($games)) {
            return '-';
        }

        $preview = array_slice($games, 0, 3);

        return implode(', ', $preview) . (count($games) > 3 ? ' ...' : '');
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

        $reference = $this->status === 'active'
            ? ($this->activated_at ?? now())
            : now();

        if ($reference->lessThanOrEqualTo($deadline)) {
            return 0;
        }

        return $deadline->diffInDays($reference);
    }

    public function getSelectionOverdueDaysAttribute(): int
    {
        return $this->selection_delay_days;
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
    }
}

