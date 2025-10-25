<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // شماره تراکنش (شناسه یکتا نمایش/پیگیری)
            $table->string('txn_number')->unique();

            // نوع فعالیت (پرداخت اشتراک، تمدید، ارتقا، بازگشت وجه، …)
            $table->string('activity')->default('subscription');

            // ارتباط‌ها
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();

            // مبالغ و زمان
            $table->unsignedBigInteger('amount'); // مبلغ به ریال/تومان (هرچه استاندارد پروژه‌ست)
            $table->dateTime('paid_at')->nullable();

            // درگاه و وضعیت
            $table->string('gateway')->nullable(); // مثلاً: zarinpal, idpay, payir
            $table->enum('status', ['success','pending','failed','refunded'])->default('pending');

            // اطلاعات تکمیلی
            $table->string('ref_code')->nullable(); // کد مرجع درگاه
            $table->json('receipt')->nullable();    // هر دیتای اضافی رسید (JSON)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
