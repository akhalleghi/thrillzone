<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UpgradeRequest;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['phone', 'name', 'email'];


    protected $hidden = [];

    public function upgradeRequests()
    {
        return $this->hasMany(UpgradeRequest::class);
    }
}
