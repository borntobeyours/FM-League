<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('league_assists', function (Blueprint $table) {
            $table->integer('player_id')->after('team_id');
            $table->dropColumn('player_name');
        });

        Schema::table('league_goals', function (Blueprint $table) {
            $table->integer('player_id')->after('team_id');
            $table->dropColumn('player_name');
        });

        Schema::table('league_reds', function (Blueprint $table) {
            $table->integer('player_id')->after('team_id');
            $table->dropColumn('player_name');
        });

        Schema::table('league_yellows', function (Blueprint $table) {
            $table->integer('player_id')->after('team_id');
            $table->dropColumn('player_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
