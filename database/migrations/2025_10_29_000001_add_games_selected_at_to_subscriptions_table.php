<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->timestamp('games_selected_at')->nullable()->after('requested_at');
        });

        DB::table('subscriptions')
            ->whereNotNull('active_games')
            ->update([
                'games_selected_at' => DB::raw('COALESCE(games_selected_at, requested_at, activated_at, purchased_at)'),
            ]);
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('games_selected_at');
        });
    }
};

