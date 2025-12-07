<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE plans
                MODIFY swap_limit ENUM('10d','15d','1m','2m','none') NOT NULL DEFAULT '1m'
            ");
        });
    }

    public function down(): void
    {
        DB::table('plans')->where('swap_limit', 'none')->update(['swap_limit' => '1m']);

        Schema::table('plans', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE plans
                MODIFY swap_limit ENUM('10d','15d','1m','2m') NOT NULL DEFAULT '1m'
            ");
        });
    }
};
