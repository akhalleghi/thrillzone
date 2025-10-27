<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Booking extends Model
{
    protected $fillable = [
        'day_of_week','date','start_time','end_time','status','user_id'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // فرمت تاریخ شمسی برای نمایش
    public function getJalaliDateAttribute()
    {
        return $this->date ? Jalalian::fromCarbon($this->date)->format('Y/m/d') : '—';
    }

    // نمایش ساعت
    public function getTimeRangeAttribute()
    {
        return "{$this->start_time} الی {$this->end_time}";
    }

    public function getDayOfWeekFaAttribute(): string
        {
        $map = [
            'saturday'  => 'شنبه',
            'sunday'    => 'یک‌شنبه',
            'monday'    => 'دوشنبه',
            'tuesday'   => 'سه‌شنبه',
            'wednesday' => 'چهارشنبه',
            'thursday'  => 'پنج‌شنبه',
            'friday'    => 'جمعه',
        ];

        return $map[strtolower($this->day_of_week)] ?? $this->day_of_week;
        }   

}
