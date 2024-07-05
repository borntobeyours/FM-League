<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use App\Models\ConfigLeague;
use App\Models\ConfigStart;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class leagueController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $activeDivisions = ConfigDivision::where('status', 1)->orderBy('division_name', 'asc')->get();
        View::share('activeDivisions', $activeDivisions);
        $this->request = $request;
    }

    public function standings($division_id)
    {
        $start      = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        if (!$start) {
            return redirect('dashboard');
        }
        $division   = ConfigDivision::find($division_id);
        $league     = ConfigLeague::where('status',1)->orderBy('id','DESC')->first();
        $teams      = Team::where('division_id', $division_id)->where('status',1)->orderBy('team_name')->get();
        $standings  = League::where('division_id', $division_id)
            ->where('league_id', $league->id)
            ->where('start_id', $start->id)
            ->orderBy('pts', 'DESC')
            ->orderBy('gd', 'DESC')
            ->get();
        return view('league.standings', [
            'division' => $division,
            'teams' => $teams,
            'standings' => $standings
        ]);
    }
}
