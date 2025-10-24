<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name','platforms','capability','concurrent_games','all_ps_store','level1_selection',
        'swap_limit','install_options','game_type','has_discount','discount_percent',
        'has_free_games','free_games_count','description','durations','prices','active'
    ];

    protected $casts = [
        'platforms'       => 'array',
        'install_options' => 'array',
        'durations'       => 'array',
        'prices'          => 'array',
        'has_discount'    => 'boolean',
        'has_free_games'  => 'boolean',
        'active'          => 'boolean',
    ];

    public function priceFor($months)
    {
        return $this->prices[$months] ?? null;
    }
}
