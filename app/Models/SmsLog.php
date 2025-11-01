<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'subscription_id',
        'mobile',
        'message',
        'purpose',
        'track_id',
        'status',
        'gateway',
        'provider_status',
        'provider_response',
        'error_message',
    ];

    // ارتباط‌ها (اختیاری ولی پیشنهاد می‌شود)
    public function user()         { return $this->belongsTo(User::class); }
    public function transaction()  { return $this->belongsTo(Transaction::class); }
    public function subscription() { return $this->belongsTo(Subscription::class); }
}
