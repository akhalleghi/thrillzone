<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'status',
        'gateway',
        'txn_number',
        'ref_code',
        'paid_at',
        'months',        // ✅ اضافه شد
        'coupon_code',   // ✅ اضافه شد
        'discount',      // ✅ اضافه شد
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'receipt' => 'array',
    ];

    // روابط
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
    }
}
