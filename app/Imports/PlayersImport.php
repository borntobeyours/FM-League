<?php

namespace App\Imports;

use App\Models\Player;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlayersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $team = Team::where('team_name', $row['team'])->first();

        return new Player([
            'name' => $row['name'],
            'position' => $row['position'],
            'team_id' => $team ? $team->id : null,
        ]);
    }
}
