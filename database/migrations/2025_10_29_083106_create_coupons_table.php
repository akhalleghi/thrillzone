<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // کد تخفیف
            $table->enum('type', ['public', 'user_specific'])->default('public'); // عمومی یا کاربری خاص
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // اگر مخصوص کاربر خاصی باشد
            $table->decimal('amount', 10, 2); // مبلغ یا درصد
            $table->enum('discount_type', ['percent', 'fixed'])->default('fixed'); // نوع تخفیف
            $table->integer('usage_limit')->default(1); // محدودیت تعداد استفاده
            $table->integer('used_count')->default(0); // چندبار استفاده شده
            $table->boolean('is_active')->default(true); // فعال / غیرفعال
            $table->timestamp('expires_at')->nullable(); // تاریخ انقضا
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
