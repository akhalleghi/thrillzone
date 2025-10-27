<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week'); // مثلاً شنبه، یک‌شنبه...
            $table->date('date'); // تاریخ شمسی معادل
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available','reserved'])->default('available');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
