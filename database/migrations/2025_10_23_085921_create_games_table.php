<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // نام بازی
            $table->string('genre')->nullable();    // ژانر (اختیاری)
            $table->string('cover')->nullable();    // مسیر فایل کاور (storage)
            $table->enum('status', ['active','inactive'])->default('active'); // وضعیت
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
