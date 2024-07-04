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
        Schema::create('config_leagues', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->year('event_year');
            $table->string('event_season');
            $table->string('league_name');
            $table->string('cup_name');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_leagues');
    }
};
