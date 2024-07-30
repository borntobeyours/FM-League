<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use App\Models\ConfigStart;
use App\Models\CupAssist;
use App\Models\CupGoals;
use App\Models\CupMatch;
use App\Models\CupRed;
use App\Models\CupYellow;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class cupController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $activeDivisions = ConfigDivision::where('status', 1)->orderBy('division_name', 'asc')->get();
        View::share('activeDivisions', $activeDivisions);
        $this->request = $request;
    }

    public function results()
    {
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        // $division = ConfigDivision::find($division_id);
        // $activeLeague = ConfigLeague::where('status', 1)->orderBy('id', 'DESC')->first();
        $league = Team::orderBy('team_name','ASC')->get();
        $results = CupMatch::where('start_id', $start->id)->orderBy('id', 'DESC')->get();

        // $players = Player::all();

        return view('cup.results', [
            'league' => $league,
            'results' => $results,
        ]);
    }

    public function saveResults()
    {
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $homeScore = (int)$this->request->score_home;
        $awayScore = (int)$this->request->score_away;

        $match = new CupMatch();
        $match->match_date = $this->request->match_date;
        $match->stage = $this->request->stage;
        $match->start_id = $start->id;
        $match->team_home_id = $this->request->home_team;
        $match->team_away_id = $this->request->away_team;
        $match->home_score = $homeScore;
        $match->away_score = $awayScore;
        $match->save();

        $this->saveMatchDetails($match->id, $this->request);

        return redirect()->back();
    }

    protected function saveMatchDetails($matchId, $request)
    {
        $this->saveGoals($matchId, $request->goal_home, $request->home_team);
        $this->saveGoals($matchId, $request->goal_away, $request->away_team);

        $this->saveAssist($matchId, $request->assist_home, $request->home_team);
        $this->saveAssist($matchId, $request->assist_away, $request->away_team);

        $this->saveYellow($matchId, $request->yellow_card_home, $request->home_team);
        $this->saveYellow($matchId, $request->yellow_card_away, $request->away_team);

        $this->saveRed($matchId, $request->red_card_home, $request->home_team);
        $this->saveRed($matchId, $request->red_card_away, $request->away_team);
    }

    protected function saveGoals($matchId, $goals, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($goals as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                CupGoals::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function saveAssist($matchId, $assists, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($assists as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                CupAssist::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function saveYellow($matchId, $yellows, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($yellows as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                CupYellow::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function saveRed($matchId, $reds, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($reds as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                CupRed::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    public function statisticsGoal(){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();

        $goalStats = CupGoals::select('team_id','player_id', DB::raw('count(*) as total_goals'))
            ->where('start_id', $start->id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('total_goals', 'desc')
            ->with(['player','team'])
            ->get();

        return view('cup.statistics.goal', [
            'goals' => $goalStats
        ]);
    }

    public function statisticsAssist(){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();

        $assistStats = CupAssist::select('team_id','player_id', DB::raw('count(*) as total_assist'))
            ->where('start_id', $start->id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('total_assist', 'desc')
            ->with(['player','team'])
            ->get();

        return view('cup.statistics.assist', [
            'assists' => $assistStats
        ]);
    }

    public function statisticsYC(){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();

        $yellowStats = CupYellow::select('team_id','player_id', DB::raw('count(*) as yellow_card'))
            ->where('start_id', $start->id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('yellow_card', 'desc')
            ->with(['player','team'])
            ->get();

        return view('cup.statistics.yellow', [
            'yellow' => $yellowStats
        ]);
    }

    public function statisticsRC(){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();

        $redStats = CupRed::select('team_id','player_id', DB::raw('count(*) as red_card'))
            ->where('start_id', $start->id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('red_card', 'desc')
            ->with(['player','team'])
            ->get();

        return view('cup.statistics.red', [
            'red' => $redStats
        ]);
    }
}
