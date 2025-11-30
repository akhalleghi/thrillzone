<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upgrade_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_plan_id')->constrained('plans')->cascadeOnDelete();
            $table->string('user_name');
            $table->json('selected_games')->nullable();
            $table->json('selected_options')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'rejected', 'done'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upgrade_requests');
    }
};
