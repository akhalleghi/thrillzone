<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'user_id', 'amount', 'discount_type',
        'usage_limit', 'used_count', 'is_active', 'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    // 🟢 برای نمایش فارسی نوع تخفیف
    public function getDiscountTypeLabelAttribute()
    {
        return $this->discount_type === 'percent' ? 'درصدی' : 'مبلغ ثابت';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // وضعیت فعال بودن
    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active) return 'غیرفعال';
        if ($this->expires_at && $this->expires_at->isPast()) return 'منقضی';
        return 'فعال';
    }

    // تاریخ شمسی
    public function getJalaliExpireAttribute(): ?string
    {
        return $this->expires_at ? Jalalian::fromCarbon($this->expires_at)->format('Y/m/d H:i') : '—';
    }
}
