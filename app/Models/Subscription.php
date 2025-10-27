<?php
// app/Models/Subscription.php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Casts\Attribute;

// class Subscription extends Model
// {
//     protected $fillable = [
//         'user_id','plan_id','duration_months','price','status',
//         'purchased_at','requested_at','activated_at','ends_at',
//         'swap_every_days','next_swap_at','active_games',
//     ];

//     protected $casts = [
//         'purchased_at'   => 'datetime',
//         'requested_at'   => 'datetime',
//         'activated_at'   => 'datetime',
//         'ends_at'        => 'datetime',
//         'next_swap_at'   => 'datetime',
//         'active_games'   => 'array',
//     ];

//     // روابط
//     public function user(){ return $this->belongsTo(User::class); }
//     public function plan(){ return $this->belongsTo(Plan::class); }

//     // آدرس نمایش‌کاورها یا نام بازی‌ها
//     public function getActiveGamesListAttribute()
//     {
//         $arr = $this->active_games ?? [];
//         if (!is_array($arr) || empty($arr)) return '—';
//         // اگر آرایه‌ای از نام‌هاست:
//         return implode('، ', array_slice($arr, 0, 3)) . (count($arr) > 3 ? ' ...' : '');
//     }

//     // چند ثانیه تا پایان (برای تایمر)
//     public function getRemainingSecondsAttribute(): ?int
//     {
//         if ($this->status !== 'active' || !$this->ends_at) return null;
//         $diff = $this->ends_at->diffInSeconds(now(), false);
//         return $diff < 0 ? abs($diff) : 0;
//     }

//     // چند ثانیه تا تعویض بعدی
//     public function getSwapRemainingSecondsAttribute(): ?int
//     {
//         if ($this->status !== 'active' || !$this->next_swap_at) return null;
//         $diff = $this->next_swap_at->diffInSeconds(now(), false);
//         return $diff < 0 ? 0 : $diff;
//     }
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    protected $fillable = [
        'user_id','plan_id','duration_months','price','status',
        'purchased_at','requested_at','activated_at','ends_at',
        'swap_every_days','next_swap_at','active_games','subscription_code',
    ];

    protected $casts = [
        'purchased_at'   => 'datetime',
        'requested_at'   => 'datetime',
        'activated_at'   => 'datetime',
        'ends_at'        => 'datetime',
        'next_swap_at'   => 'datetime',
        'active_games'   => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | روابط
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (دسترسی‌های نمایشی)
    |--------------------------------------------------------------------------
    */

    // لیست بازی‌های فعال به‌صورت رشته
    public function getActiveGamesListAttribute()
    {
        $arr = $this->active_games ?? [];
        if (!is_array($arr) || empty($arr)) return '—';
        return implode('، ', array_slice($arr, 0, 3)) . (count($arr) > 3 ? ' ...' : '');
    }

    // چند ثانیه تا پایان (برای تایمر)
    public function getRemainingSecondsAttribute(): ?int
    {
        if ($this->status !== 'active' || !$this->ends_at) return null;
        $diff = $this->ends_at->diffInSeconds(now(), false);
        return $diff < 0 ? abs($diff) : 0;
    }

    // چند ثانیه تا تعویض بعدی
    public function getSwapRemainingSecondsAttribute(): ?int
    {
        if ($this->status !== 'active' || !$this->next_swap_at) return null;
        $diff = $this->next_swap_at->diffInSeconds(now(), false);
        return $diff < 0 ? 0 : $diff;
    }

    /*
    |--------------------------------------------------------------------------
    | Boot: ساخت خودکار subscription_code منحصربه‌فرد
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            if (empty($subscription->subscription_code)) {
                do {
                    // تولید یک عدد رندوم ۶ رقمی
                    $randomNumber = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $code = 'TZ-' . $randomNumber;
                } while (self::where('subscription_code', $code)->exists()); // اگر قبلاً وجود داشت، تکرار کن

                $subscription->subscription_code = $code;
            }
        });
    }
}
