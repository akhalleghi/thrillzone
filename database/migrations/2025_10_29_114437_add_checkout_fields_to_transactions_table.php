<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // اگر قبلاً ستون‌ها نبودند، اضافه‌شان کن
            if (!Schema::hasColumn('transactions', 'months')) {
                $table->unsignedTinyInteger('months')->nullable()->after('paid_at'); // 1..24
            }
            if (!Schema::hasColumn('transactions', 'coupon_code')) {
                $table->string('coupon_code', 64)->nullable()->after('months');
            }
            if (!Schema::hasColumn('transactions', 'discount')) {
                $table->unsignedInteger('discount')->default(0)->after('coupon_code'); // مبلغ تخفیف به تومان
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'discount')) {
                $table->dropColumn('discount');
            }
            if (Schema::hasColumn('transactions', 'coupon_code')) {
                $table->dropColumn('coupon_code');
            }
            if (Schema::hasColumn('transactions', 'months')) {
                $table->dropColumn('months');
            }
        });
    }
};
