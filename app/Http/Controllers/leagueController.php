<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use App\Models\ConfigLeague;
use App\Models\ConfigStart;
use App\Models\League;
use App\Models\LeagueAssist;
use App\Models\LeagueGoals;
use App\Models\LeagueMatch;
use App\Models\LeagueRed;
use App\Models\LeagueYellow;
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

    public function results($division_id)
    {
        $start              = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $division           = ConfigDivision::find($division_id);
        $activeLeague       = ConfigLeague::where('status',1)->orderBy('id','DESC')->first();
        $league             = League::with('team')->where('division_id', $division_id)->where('league_id', $activeLeague->id)->get();
        $results            = LeagueMatch::where('start_id', $start->id)->where('division_id', $division_id)->orderBy('match_date','DESC')->get();
        return view('league.results', [
            'division' => $division,
            'league' => $league,
            'results' => $results
        ]);
    }

    public function saveResults($division_id)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $homeScore = (int) $this->request->score_home;
        $awayScore = (int) $this->request->score_away;

        //home team
        $home = League::find($this->request->home_team);
        $home->increment('mp', 1);
        $home->increment('gf', $homeScore);
        $home->increment('ga', $awayScore);

        if ($homeScore > $awayScore) {
            $home->increment('w', 1);
            $home->increment('pts', 3);
        } elseif ($homeScore < $awayScore) {
            $home->increment('l', 1);
        } else {
            $home->increment('d', 1);
            $home->increment('pts', 1);
        }
        $home->save();

        //away team
        $away = League::find($this->request->away_team);
        $away->increment('mp', 1);
        $away->increment('gf', $awayScore);
        $away->increment('ga', $homeScore);

        if ($awayScore > $homeScore) {
            $away->increment('w', 1);
            $away->increment('pts', 3);
        } elseif ($awayScore < $homeScore) {
            $away->increment('l', 1);
        } else {
            $away->increment('d', 1);
            $away->increment('pts', 1);
        }
        $away->save();

        //save match
        $match = new LeagueMatch();
        $match->match_date = $this->request->match_date;
        $match->start_id = $start->id;
        $match->division_id = $division_id;
        $match->home_league_id = $this->request->home_team;
        $match->away_league_id = $this->request->away_team;
        $match->home_score = $homeScore;
        $match->away_score = $awayScore;
        $match->save();

        $this->saveGoals($match->id, $division_id, $this->request->goal_home, $this->request->home_team);
        $this->saveGoals($match->id, $division_id, $this->request->goal_away, $this->request->away_team);

        $this->saveAssist($match->id, $division_id, $this->request->assist_home, $this->request->home_team);
        $this->saveAssist($match->id, $division_id, $this->request->assist_away, $this->request->away_team);

        $this->saveYellow($match->id, $division_id, $this->request->yellow_card_home, $this->request->home_team);
        $this->saveYellow($match->id, $division_id, $this->request->yellow_card_away, $this->request->away_team);

        $this->saveRed($match->id, $division_id, $this->request->red_card_home, $this->request->home_team);
        $this->saveRed($match->id, $division_id, $this->request->red_card_away, $this->request->away_team);

        return redirect()->back();
    }

    protected function saveGoals($match_id, $division_id, $goals, $league_id)
    {
        $league = League::find($league_id);
        $goalScorers = explode("\n", trim($goals));
        foreach ($goalScorers as $scorer) {
            if (!empty(trim($scorer))) {
                $save = new LeagueGoals();
                $save->start_id = $league->start_id;
                $save->match_id = $match_id;
                $save->division_id = $division_id;
                $save->team_id = $league->team_id;
                $save->player_name = trim($scorer);
                $save->save();
            }
        }
    }

    protected function saveAssist($match_id, $division_id, $assisst, $league_id)
    {
        $league = League::find($league_id);
        $assistSent = explode("\n", trim($assisst));
        foreach ($assistSent as $asist) {
            if (!empty(trim($asist))) {
                $save = new LeagueAssist();
                $save->start_id = $league->start_id;
                $save->match_id = $match_id;
                $save->division_id = $division_id;
                $save->team_id = $league->team_id;
                $save->player_name = trim($asist);
                $save->save();
            }
        }
    }

    protected function saveYellow($match_id, $division_id, $yellow, $league_id)
    {
        $league = League::find($league_id);
        $getYellow = explode("\n", trim($yellow));
        foreach ($getYellow as $yc) {
            if (!empty(trim($yc))) {
                $save = new LeagueYellow();
                $save->match_id = $match_id;
                $save->start_id = $league->start_id;
                $save->division_id = $division_id;
                $save->team_id = $league->team_id;
                $save->player_name = trim($yc);
                $save->save();
            }
        }
    }

    protected function saveRed($match_id, $division_id, $red, $league_id)
    {
        $league = League::find($league_id);
        $getRed = explode("\n", trim($red));
        foreach ($getRed as $rc) {
            if (!empty(trim($rc))) {
                $save = new LeagueRed();
                $save->start_id = $league->start_id;
                $save->match_id = $match_id;
                $save->division_id = $division_id;
                $save->team_id = $league->team_id;
                $save->player_name = trim($rc);
                $save->save();
            }
        }
    }
}
