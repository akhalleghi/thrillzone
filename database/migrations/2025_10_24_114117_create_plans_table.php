<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // نام پلن
            $table->json('platforms')->nullable(); // ["ps4","ps5"]
            $table->enum('capability', ['online','offline','both'])->default('both');
            $table->unsignedTinyInteger('concurrent_games')->default(1);
            $table->boolean('all_ps_store')->default(false);
            $table->unsignedTinyInteger('level1_selection')->default(1);
            $table->enum('swap_limit', ['10d','15d','1m','2m'])->default('1m');
            $table->json('install_options')->nullable();
            $table->string('game_type')->nullable();
            $table->boolean('has_discount')->default(false);
            $table->unsignedTinyInteger('discount_percent')->nullable();
            $table->boolean('has_free_games')->default(false);
            $table->unsignedTinyInteger('free_games_count')->nullable();
            $table->text('description')->nullable();
            $table->json('durations')->nullable(); // [3,6,12]
            $table->json('prices')->nullable(); // {"3":120000,"6":200000}
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('plans');
    }
};
