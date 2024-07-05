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
        Schema::create('league_matches', function (Blueprint $table) {
            $table->id();
            $table->date('match_date');
            $table->integer('division_id');
            $table->integer('home_league_id');
            $table->integer('home_score');
            $table->integer('away_league_id');
            $table->integer('away_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_matches');
    }
};
