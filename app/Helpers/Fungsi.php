<?php

use App\Models\League;
use App\Models\Team;

class Fungsi {

    public static function get_team_from_league($id){
        $league = League::find($id);
        $team   = Team::find($league->team_id);
        return $team->team_name;
    }

    public static function get_team_from_id($id){
        $team   = Team::find($id);
        if ($id == 999999) {
            return 'Release';
        }
        return $team->team_name;
    }

}
