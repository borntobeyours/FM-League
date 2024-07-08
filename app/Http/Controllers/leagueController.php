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
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        if (!$start) {
            return redirect('dashboard');
        }

        $division = ConfigDivision::find($division_id);
        $league = ConfigLeague::where('status', 1)->orderBy('id', 'DESC')->first();
        $teams = Team::where('division_id', $division_id)->where('status', 1)->orderBy('team_name')->get();
        $standings = League::where('division_id', $division_id)
            ->where('league_id', $league->id)
            ->where('start_id', $start->id)
            ->orderBy('pts', 'DESC')
            ->orderBy('gd', 'DESC')
            ->get();

        return view('league.standings', [
            'division' => $division,
            'teams' => $teams,
            'standings' => $standings,
        ]);
    }

    public function results($division_id)
    {
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $division = ConfigDivision::find($division_id);
        $activeLeague = ConfigLeague::where('status', 1)->orderBy('id', 'DESC')->first();
        $league = League::with('team')->where('division_id', $division_id)->where('league_id', $activeLeague->id)->get();
        $results = LeagueMatch::where('start_id', $start->id)->where('division_id', $division_id)->orderBy('match_date', 'DESC')->get();

        $players = Player::all();

        return view('league.results', [
            'division' => $division,
            'league' => $league,
            'results' => $results,
            'players' => $players,
        ]);
    }

    public function saveResults($division_id)
    {
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $homeScore = (int)$this->request->score_home;
        $awayScore = (int)$this->request->score_away;

        $this->updateTeamStats($this->request->home_team, $homeScore, $awayScore, true);
        $this->updateTeamStats($this->request->away_team, $awayScore, $homeScore, false);

        $match = new LeagueMatch();
        $match->match_date = $this->request->match_date;
        $match->start_id = $start->id;
        $match->division_id = $division_id;
        $match->home_league_id = $this->request->home_team;
        $match->away_league_id = $this->request->away_team;
        $match->home_score = $homeScore;
        $match->away_score = $awayScore;
        $match->save();

        $this->saveMatchDetails($match->id, $division_id, $this->request);

        return redirect()->back();
    }

    protected function updateTeamStats($teamId, $goalsFor, $goalsAgainst, $isHome)
    {
        $team = League::find($teamId);
        $team->increment('mp', 1);
        $team->increment('gf', $goalsFor);
        $team->increment('ga', $goalsAgainst);

        if ($goalsFor > $goalsAgainst) {
            $team->increment('w', 1);
            $team->increment('pts', 3);
        } elseif ($goalsFor < $goalsAgainst) {
            $team->increment('l', 1);
        } else {
            $team->increment('d', 1);
            $team->increment('pts', 1);
        }

        $team->save();
    }

    protected function saveMatchDetails($matchId, $divisionId, $request)
    {
        $this->saveGoals($matchId, $divisionId, $request->goal_home, $request->home_team);
        $this->saveGoals($matchId, $divisionId, $request->goal_away, $request->away_team);

        $this->saveAssist($matchId, $divisionId, $request->assist_home, $request->home_team);
        $this->saveAssist($matchId, $divisionId, $request->assist_away, $request->away_team);

        $this->saveYellow($matchId, $divisionId, $request->yellow_card_home, $request->home_team);
        $this->saveYellow($matchId, $divisionId, $request->yellow_card_away, $request->away_team);

        $this->saveRed($matchId, $divisionId, $request->red_card_home, $request->home_team);
        $this->saveRed($matchId, $divisionId, $request->red_card_away, $request->away_team);
    }

    protected function saveGoals($matchId, $divisionId, $goals, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($goals as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                LeagueGoals::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'division_id' => $divisionId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function saveAssist($matchId, $divisionId, $assists, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($assists as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                LeagueAssist::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'division_id' => $divisionId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function saveYellow($matchId, $divisionId, $yellows, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($yellows as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                LeagueYellow::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'division_id' => $divisionId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function saveRed($matchId, $divisionId, $reds, $teamId)
    {
        $start = ConfigStart::where('status',1)->orderBy('id','DESC')->first();
        $team = Team::find($teamId);
        foreach ($reds as $playerId => $count) {
            for ($i = 0; $i < $count; $i++) {
                LeagueRed::create([
                    'start_id' => $start->id,
                    'match_id' => $matchId,
                    'division_id' => $divisionId,
                    'team_id' => $team->id,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    public function statisticsGoal($division_id){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $division = ConfigDivision::find($division_id);

        $goalStats = LeagueGoals::select('team_id','player_id', DB::raw('count(*) as total_goals'))
            ->where('start_id', $start->id)
            ->where('division_id', $division_id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('total_goals', 'desc')
            ->with(['player','team'])
            ->get();

        return view('league.statistics.goal', [
            'division' => $division,
            'goals' => $goalStats
        ]);
    }

    public function statisticsAssist($division_id){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $division = ConfigDivision::find($division_id);

        $assistStats = LeagueAssist::select('team_id','player_id', DB::raw('count(*) as total_assist'))
            ->where('start_id', $start->id)
            ->where('division_id', $division_id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('total_assist', 'desc')
            ->with(['player','team'])
            ->get();

        return view('league.statistics.assist', [
            'division' => $division,
            'assists' => $assistStats
        ]);
    }

    public function statisticsYC($division_id){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $division = ConfigDivision::find($division_id);

        $yellowStats = LeagueYellow::select('team_id','player_id', DB::raw('count(*) as yellow_card'))
            ->where('start_id', $start->id)
            ->where('division_id', $division_id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('yellow_card', 'desc')
            ->with(['player','team'])
            ->get();

        return view('league.statistics.yellow', [
            'division' => $division,
            'yellow' => $yellowStats
        ]);
    }

    public function statisticsRC($division_id){
        $start = ConfigStart::where('status', 1)->orderBy('id', 'DESC')->first();
        $division = ConfigDivision::find($division_id);

        $redStats = LeagueRed::select('team_id','player_id', DB::raw('count(*) as red_card'))
            ->where('start_id', $start->id)
            ->where('division_id', $division_id)
            ->groupBy('team_id')
            ->groupBy('player_id')
            ->orderBy('red_card', 'desc')
            ->with(['player','team'])
            ->get();

        return view('league.statistics.red', [
            'division' => $division,
            'red' => $redStats
        ]);
    }
}
