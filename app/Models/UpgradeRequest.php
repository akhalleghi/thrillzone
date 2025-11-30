<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_DONE = 'done';

    protected $fillable = [
        'request_number',
        'user_id',
        'subscription_id',
        'requested_plan_id',
        'requested_duration',
        'user_name',
        'selected_games',
        'selected_options',
        'description',
        'status',
    ];

    protected $casts = [
        'selected_games' => 'array',
        'selected_options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function requestedPlan()
    {
        return $this->belongsTo(Plan::class, 'requested_plan_id');
    }
}
