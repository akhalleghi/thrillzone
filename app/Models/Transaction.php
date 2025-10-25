<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'txn_number', 'activity', 'user_id', 'plan_id', 'amount',
        'paid_at', 'gateway', 'status', 'ref_code', 'receipt',
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
