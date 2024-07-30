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
        Schema::create('cup_matches', function (Blueprint $table) {
            $table->id();
            $table->date('match_date');
            $table->string('stage');
            $table->integer('start_id');
            $table->integer('team_home_id');
            $table->integer('home_score');
            $table->integer('team_away_id');
            $table->integer('away_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cup_matches');
    }
};
