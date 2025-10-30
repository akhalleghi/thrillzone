<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Carbon;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name'     => 'Default Admin',
            'email'    => 'admin@example.com',
            'phone'    => '09120000000',
            'password' => bcrypt('password'),
        ]);

        $plan = Plan::first() ?? Plan::create([
            'name'               => 'Test Plan',
            'platforms'          => ['ps4', 'ps5'],
            'capability'         => 'both',
            'concurrent_games'   => 2,
            'swap_limit'         => '1m',
            'install_options'    => ['online', 'inperson'],
            'durations'          => [3, 6, 12],
            'prices'             => ['3' => 200000, '6' => 350000, '12' => 600000],
            'active'             => true,
        ]);

        $now = Carbon::now();

        // Waiting – inside 2-day grace window (no delay)
        Subscription::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'duration_months' => 3,
            'price'           => 200000,
            'status'          => 'waiting',
            'purchased_at'    => $now->copy()->subDay(),
            'swap_every_days' => 30,
        ]);

        // Waiting – overdue by 5 days (should show delay)
        Subscription::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'duration_months' => 6,
            'price'           => 350000,
            'status'          => 'waiting',
            'purchased_at'    => $now->copy()->subDays(7),
            'swap_every_days' => 30,
        ]);

        // Active – activated without delay
        $activatedNoDelay = $now->copy()->subDays(2);
        Subscription::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'duration_months' => 6,
            'price'           => 350000,
            'status'          => 'active',
            'purchased_at'    => $activatedNoDelay->copy()->subDay(),
            'activated_at'    => $activatedNoDelay,
            'ends_at'         => $activatedNoDelay->copy()->addMonths(6),
            'swap_every_days' => 30,
            'next_swap_at'    => $now->copy()->addDays(28),
            'active_games'    => ['FIFA 25', 'Call of Duty'],
        ]);

        // Active – activated with 8-day delay (should be shortened by 8 days)
        $delayDays = 8;
        $activatedWithDelay = $now->copy()->subDay();
        Subscription::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'duration_months' => 6,
            'price'           => 350000,
            'status'          => 'active',
            'purchased_at'    => $activatedWithDelay->copy()->subDays($delayDays + 1),
            'activated_at'    => $activatedWithDelay,
            'ends_at'         => $activatedWithDelay->copy()->addMonths(6)->subDays($delayDays),
            'swap_every_days' => 30,
            'next_swap_at'    => $now->copy()->addDays(25),
            'active_games'    => ['Cyberpunk 2077', 'EA FC 25'],
        ]);

        // Ended – historical record
        Subscription::create([
            'user_id'         => $user->id,
            'plan_id'         => $plan->id,
            'duration_months' => 12,
            'price'           => 600000,
            'status'          => 'ended',
            'purchased_at'    => $now->copy()->subYear(),
            'activated_at'    => $now->copy()->subMonths(12),
            'ends_at'         => $now->copy()->subDays(5),
            'swap_every_days' => 60,
            'active_games'    => ['GTA V'],
        ]);
    }
}
