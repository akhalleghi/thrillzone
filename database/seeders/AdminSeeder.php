<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'name'     => 'مدیر ارشد',
                'email'    => 'admin@example.com',
                'password' => Hash::make('Ss123456'), // حتماً بعداً عوضش کن
            ]
        );
    }
}
