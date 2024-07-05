<?php

use App\Models\League;
use App\Models\Team;

class Fungsi {

    public static function get_team_from_league($id){
        $league = League::find($id);
        $team   = Team::find($league->team_id);
        return $team->team_name;
    }
}
