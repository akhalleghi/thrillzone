<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SwapRequest;
use Illuminate\Support\Carbon;

class SwapRequestSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'کاربر تستی',
            'email' => 'test@example.com',
            'phone' => '09120000000',
            'password' => bcrypt('12345678'),
        ]);

        $plan = Plan::first() ?? Plan::create([
            'name' => 'پلن ۳ ماهه ویژه',
            'durations' => [3],
            'prices' => ['3' => 200000],
            'swap_limit' => '1m',
            'active' => true,
        ]);

        $sub = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'duration_months' => 3,
            'price' => 200000,
            'status' => 'active',
            'purchased_at' => now()->subDays(5),
            'activated_at' => now()->subDays(3),
            'ends_at' => now()->addMonths(3),
            'swap_every_days' => 30,
            'next_swap_at' => now()->addDays(5),
            'active_games' => ['FIFA 25', 'Spider-Man 2'],
        ]);

        SwapRequest::create([
            'subscription_id' => $sub->id,
            'user_id' => $user->id,
            'requested_games' => ['GTA V', 'Hogwarts Legacy'],
            'status' => 'pending',
        ]);
    }
}
