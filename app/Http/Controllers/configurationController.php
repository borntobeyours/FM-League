<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use App\Models\ConfigLeague;
use Illuminate\Http\Request;

class configurationController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function leagueAndCup()
    {
        $latestConfig = ConfigLeague::latest('id')->first();
        $divisions = ConfigDivision::where('status', 1)->get();

        return view('configuration.league', [
            'data' => $latestConfig,
            'divisions' => $divisions
        ]);
    }

    public function saveLeagueAndCup()
    {
        $latestConfig = ConfigLeague::orderBy('id', 'DESC')->first();

        $isDifferent = !$latestConfig || (
            $latestConfig->event_name !== $this->request->event_name ||
            $latestConfig->event_year !== $this->request->event_year ||
            $latestConfig->event_season !== $this->request->event_season ||
            $latestConfig->league_name !== $this->request->league_name ||
            $latestConfig->cup_name !== $this->request->cup_name
        );

        if ($isDifferent) {
            $newConfig = new ConfigLeague();
            $newConfig->event_name = $this->request->event_name;
            $newConfig->event_year = $this->request->event_year;
            $newConfig->event_season = $this->request->event_season;
            $newConfig->league_name = $this->request->league_name;
            $newConfig->cup_name = $this->request->cup_name;
            $newConfig->save();
        }

        return redirect()->back();
    }

    public function division()
    {
        $data = ConfigDivision::where('status',1)->get();
        return view('configuration.division', compact(['data']));
    }

    public function saveDivision()
    {
        $existingDivision = ConfigDivision::where('division_name', $this->request->division_name)
            ->where('status', 1)
            ->first();

        if (!$existingDivision) {
            ConfigDivision::create([
                'division_name' => $this->request->division_name
            ]);
        }

        return redirect()->back();
    }

    public function modifyDivision($id)
    {
        $division = ConfigDivision::findOrFail($id);
        $division->update([
            'division_name' => $this->request->division_name
        ]);

        return redirect()->back()->with('success', 'Division updated successfully!');
    }

    public function deleteDivision($id)
    {
        $division = ConfigDivision::findOrFail($id);
        $division->update([
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Division deleted successfully!');
    }

    public function teams()
    {
        return view('configuration.teams');
    }


}
