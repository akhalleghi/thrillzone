<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwapRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'user_id',
        'requested_games',
        'status',
    ];

    protected $casts = [
        'requested_games' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
