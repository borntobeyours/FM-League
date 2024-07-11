<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_date',
        'player_id',
        'from_team_id',
        'to_team_id'
    ];

    public function player() {
        return $this->belongsTo(Player::class);
    }
}
