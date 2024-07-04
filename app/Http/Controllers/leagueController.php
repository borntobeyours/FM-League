<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
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
        $league = ConfigDivision::find($division_id);
        $teams = Team::where('division_id', $division_id)->where('status',1)->orderBy('team_name')->get();
        return view('league.standings', [
            'league' => $league,
            'teams' => $teams
        ]);
    }
}
