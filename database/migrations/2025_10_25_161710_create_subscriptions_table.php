<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_subscriptions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();

            // مدت اشتراک (برحسب ماه: 3/6/12)
            $table->unsignedTinyInteger('duration_months');

            // قیمت نهایی (اختیاری)
            $table->unsignedBigInteger('price')->nullable();

            // وضعیت: waiting, active, ended
            $table->enum('status', ['waiting','active','ended'])->default('waiting');

            // زمان‌ها
            $table->timestamp('purchased_at')->nullable();
            $table->timestamp('requested_at')->nullable();   // زمان ثبت درخواست/انتخاب بازی
            $table->timestamp('activated_at')->nullable();   // تاریخ فعال‌سازی
            $table->timestamp('ends_at')->nullable();        // تاریخ پایان

            // چرخه تعویض (روز)؛ از روی پلن در لحظه خرید کپی می‌کنیم تا بعدها تغییر پلن اثری نذاره
            $table->unsignedSmallInteger('swap_every_days')->nullable();
            $table->timestamp('next_swap_at')->nullable();   // زمان بعدی مجاز برای تعویض

            // بازی‌های فعال (نام‌ها یا شناسه‌ها)
            $table->json('active_games')->nullable();

            $table->timestamps();

            $table->index(['status','activated_at','ends_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('subscriptions');
    }
};
