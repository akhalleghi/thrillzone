<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();

            // ارتباط‌های اختیاری با سایر جداول
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('transaction_id')->nullable()->index();
            $table->unsignedBigInteger('subscription_id')->nullable()->index();

            // اطلاعات اصلی پیامک
            $table->string('mobile', 20)->index();
            $table->text('message'); // محتوای پیامک (UTF-8)
            $table->string('purpose', 50)->nullable()->index(); // otp | payment_success | payment_failed | custom | ...

            // برای ردیابی بهتر پرداخت‌ها
            $table->string('track_id', 64)->nullable()->index();

            // وضعیت ارسال
            $table->enum('status', ['sent', 'failed', 'missing_config', 'curl_error'])->default('sent')->index();

            // اطلاعات فنی
            $table->string('gateway', 50)->nullable()->index(); // نام سرویس‌دهنده
            $table->string('provider_status', 100)->nullable(); // کد یا متن وضعیت برگشتی از سرویس
            $table->text('provider_response')->nullable(); // پاسخ کامل سرویس
            $table->text('error_message')->nullable(); // متن خطای احتمالی

            $table->timestamps();

            // ایندکس‌های مفید
            $table->index(['mobile', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
