<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 'genre', 'cover', 'status' , 'type','level'
    ];
    protected $casts    = ['level' => 'integer'];

    // آدرس کامل کاور برای نمایش
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover) {
            return asset('storage/' . ltrim($this->cover, '/'));
        }
        // تصویر پیش‌فرض اگر کاوری نبود
        return 'https://via.placeholder.com/64x40?text=Game';
    }
}
