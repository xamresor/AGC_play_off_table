<?php

use App\Models\Team;
use App\Services\TeamService;

$teamNames = [];
$division = strtoupper($division ?? '-');

$data = (new TeamService())->getDivisionResultsData($division) ?? [];

foreach ($data as $teamData) {
    if (!$teamData['team'] instanceof Team) {
        throw new Exception('something wrong with team list.');
    }
    $teamNames[] = $teamData['team']->name;
}
?>


<style>
    table.division {
        width: -webkit-fill-available;
    }

    table.division,
    table.division th,
    table.division td {
        border: 1px solid black;
        text-align: center;
    }

    table.teams {
        min-width: 193px;
        display: table-cell;
        padding: 10px;
    }

    table.teams th,
    table.teams td {
        border: 1px solid black;
        text-align: center;
    }
</style>

<table class="division">
    <caption>
        Division {{ $division ?? 'NaN' }}
    </caption>
    <thead>
    <tr>
        <th scope="col">Teams</th>
        @foreach ($teamNames as $name)
            <th scope="col">{{ $name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $teamData)
        <tr>
            <th scope="row">{{$teamData['team']->name}}</th>
            @foreach ($teamData['gameScores'] as $score)
                @if (!is_null($score))
                    <td>{{$score}}</td>
                @else
                    <td style="background: darkgrey;"></td>
                @endif
            @endforeach
            <td>{{$teamData['score']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
