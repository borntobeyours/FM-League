<?php

namespace App\Http\Controllers;

use App\Imports\PlayersImport;
use App\Models\ConfigDivision;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class DBPlayerController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $activeDivisions = ConfigDivision::where('status', 1)->orderBy('division_name', 'asc')->get();
        View::share('activeDivisions', $activeDivisions);
        $this->request = $request;
    }

    public function player()
    {
        $players = Player::all();
        return view('database.player', [
            'players' => $players
        ]);
    }

    public function importPlayer()
    {
        $this->request->validate([
            'import_data' => 'required|file|mimes:xls,xlsx',
        ]);

        Excel::import(new PlayersImport, $this->request->file('import_data'));

        return redirect()->back()->with('success', 'Players imported successfully!');
    }

    public function getPlayersByTeam($teamId)
    {
        $players = Player::where('team_id', $teamId)->get();
        return response()->json($players);
    }
}
