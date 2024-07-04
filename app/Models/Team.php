<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'team_name',
        'is_playing',
        'status'
    ];

    public function division() {
        return $this->belongsTo(ConfigDivision::class);
    }
}
