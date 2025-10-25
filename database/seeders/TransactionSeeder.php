<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Transaction, User, Plan};
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // دریافت کاربر و پلن برای اتصال
        $user = User::first();
        $plan = Plan::first();

        // اگر کاربر یا پلن وجود نداشت، یکی ایجاد می‌کنیم (برای تست)
        if (!$user) {
            $user = \App\Models\User::factory()->create([
                'name' => 'کاربر تست',
                'phone' => '09120000000',
            ]);
        }

        if (!$plan) {
            $plan = \App\Models\Plan::create([
                'name' => 'پلن تستی',
                'platforms' => ['ps5'],
                'capability' => 'online',
                'concurrent_games' => 1,
                'all_ps_store' => true,
                'level1_selection' => 5,
                'swap_limit' => '1m',
                'install_options' => ['online'],
                'game_type' => 'اکشن',
                'has_discount' => false,
                'durations' => [3,6,12],
                'prices' => ['3'=>120000,'6'=>200000,'12'=>350000],
                'active' => true,
            ]);
        }

        // ۳ تراکنش تستی
        $samples = [
            [
                'activity'   => 'خرید اشتراک',
                'amount'     => 325000,
                'gateway'    => 'zarinpal',
                'status'     => 'success',
                'ref_code'   => 'ZP-'.Str::upper(Str::random(6)),
                'paid_at'    => now()->subDays(1),
            ],
            [
                'activity'   => 'تمدید پلن',
                'amount'     => 180000,
                'gateway'    => 'idpay',
                'status'     => 'pending',
                'ref_code'   => 'ID-'.Str::upper(Str::random(6)),
                'paid_at'    => now()->subDays(2),
            ],
            [
                'activity'   => 'بازگشت وجه',
                'amount'     => 150000,
                'gateway'    => 'payir',
                'status'     => 'refunded',
                'ref_code'   => 'PR-'.Str::upper(Str::random(6)),
                'paid_at'    => now()->subDays(3),
            ],
        ];

        foreach ($samples as $data) {
            Transaction::create(array_merge($data, [
                'txn_number' => 'TXN-'.mt_rand(100000,999999),
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'receipt'    => [
                    'authority' => Str::random(10),
                    'card_mask' => '6037-****-****-'.rand(1000,9999),
                ],
            ]));
        }

        $this->command->info('✅ سه تراکنش تستی با موفقیت ایجاد شد.');
    }
}
