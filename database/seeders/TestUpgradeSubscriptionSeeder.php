<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TestUpgradeSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Upgrade Tester',
            'email' => 'upgrade@example.com',
            'phone' => '09120000001',
        ]);

        $plan = Plan::first() ?? Plan::create([
            'name'             => 'Basic Upgrade Plan',
            'platforms'        => ['ps5'],
            'capability'       => 'both',
            'concurrent_games' => 1,
            'swap_limit'       => '1m',
            'install_options'  => ['online'],
            'durations'        => [1, 3],
            'prices'           => ['1' => 120000, '3' => 260000],
            'active'           => true,
        ]);

        $start = Carbon::now()->subDays(40);

        Subscription::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'duration_months' => 3,
            'price'           => 260000,
            'status'          => 'active',
            'purchased_at'    => $start,
            'activated_at'    => $start,
            'ends_at'         => $start->copy()->addMonths(3),
            'swap_every_days' => 30,
            'next_swap_at'    => $start->copy()->addDays(30),
            'active_games'    => ['بازی سطح ۱', 'بازی سطح ۲'],
        ]);
    }
}
