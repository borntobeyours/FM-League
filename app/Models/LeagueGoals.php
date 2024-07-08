<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeagueGoals extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_id',
        'division_id',
        'match_id',
        'team_id',
        'player_id'
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function player() {
        return $this->belongsTo(Player::class);
    }
}
