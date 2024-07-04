<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use App\Models\ConfigLeague;
use App\Models\ConfigStart;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class dashboardController extends Controller
{
    public function __construct()
    {
        $activeDivisions = ConfigDivision::where('status', 1)->orderBy('division_name', 'asc')->get();
        View::share('activeDivisions', $activeDivisions);
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function start()
    {
        $league = ConfigLeague::where('status',1)->orderBy('id','DESC')->first();
        $event = ConfigStart::where('league_id', $league->id)->where('status',1)->orderBy('id','DESC')->first();
        $teams   = Team::where('status',1)->get();

        if (!$event) {
            $start = new ConfigStart();
            $start->league_id = $league->id;
            $start->status = 1;
            $start->save();

            foreach ($teams as $item) {
                $save = new League();
                $save->start_id = $start->id;
                $save->league_id = $league->id;
                $save->division_id = $item->division_id;
                $save->team_id = $item->id;
                $save->save();
            }

            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
}
