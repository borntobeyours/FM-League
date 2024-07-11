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
        Schema::create('player_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('transfer_date');
            $table->integer('player_id');
            $table->integer('from_team_id');
            $table->integer('to_team_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_transfers');
    }
};
