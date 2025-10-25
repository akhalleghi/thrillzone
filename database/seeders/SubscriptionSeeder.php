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
        // اگر هنوز کاربر یا پلن وجود ندارد، چند مورد تستی می‌سازیم
        $user = User::first() ?? User::factory()->create([
            'name' => 'امین خالقی',
            'email' => 'admin@example.com',
            'phone' => '09120000000',
            'password' => bcrypt('password'),
        ]);

        $plan = Plan::first() ?? Plan::create([
            'name' => 'پلن تستی',
            'platforms' => ['ps4', 'ps5'],
            'capability' => 'both',
            'concurrent_games' => 2,
            'swap_limit' => '1m',
            'install_options' => ['online', 'inperson'],
            'durations' => [3, 6, 12],
            'prices' => ['3' => 200000, '6' => 350000, '12' => 600000],
            'active' => true,
        ]);

        // حالا سه اشتراک تستی می‌سازیم
        $now = Carbon::now();

        // 1️⃣ اشتراک در انتظار انتخاب بازی
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'duration_months' => 3,
            'price' => 200000,
            'status' => 'waiting',
            'purchased_at' => $now->copy()->subDays(2),
            'swap_every_days' => 30,
        ]);

        // 2️⃣ اشتراک فعال
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'duration_months' => 6,
            'price' => 350000,
            'status' => 'active',
            'purchased_at' => $now->copy()->subWeek(),
            'requested_at' => $now->copy()->subDays(5),
            'activated_at' => $now->copy()->subDays(3),
            'ends_at' => $now->copy()->addMonths(6),
            'swap_every_days' => 30,
            'next_swap_at' => $now->copy()->addDays(20),
            'active_games' => ['FIFA 25', 'Call of Duty'],
        ]);

        // 3️⃣ اشتراک پایان یافته
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'duration_months' => 12,
            'price' => 600000,
            'status' => 'ended',
            'purchased_at' => $now->copy()->subYear(),
            'activated_at' => $now->copy()->subMonths(12),
            'ends_at' => $now->copy()->subDays(5),
            'swap_every_days' => 60,
            'active_games' => ['GTA V'],
        ]);
    }
}
