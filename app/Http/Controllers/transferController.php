<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use App\Models\Player;
use App\Models\PlayerTransfer;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class transferController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $activeDivisions = ConfigDivision::where('status', 1)->orderBy('division_name', 'asc')->get();
        View::share('activeDivisions', $activeDivisions);
        $this->request = $request;
    }

    public function index()
    {
        //TODO : Transfer price included
        $players    = Player::orderBy('name','ASC')->get();
        $teams      = Team::orderBy('team_name','ASC')->get();
        $transfer   = PlayerTransfer::orderBy('id','DESC')->get();
        return view('transfer.index', [
            'players' => $players,
            'teams' => $teams,
            'transfer' => $transfer
        ]);
    }

    public function save()
    {
        // Create and save a new PlayerTransfer record
        $transfer = new PlayerTransfer([
            'transfer_date' => $this->request->transfer_date,
            'player_id' => $this->request->player_id,
            'from_team_id' => $this->request->from_team_id,
            'to_team_id' => $this->request->to_team_id,
        ]);
        $transfer->save();

        // Find the player being transferred
        $player = Player::findOrFail($this->request->player_id);

        // If the player is being transferred to a special team (e.g., team ID 999999), delete the player
        if ($this->request->to_team_id == 999999) {
            $player->delete();
        } else {
            // Otherwise, update the player's team ID and save
            $player->team_id = $this->request->to_team_id;
            $player->save();
        }

        // Redirect back to the previous page
        return redirect()->back();
    }

}
