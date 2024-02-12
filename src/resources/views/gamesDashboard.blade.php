<?php

use App\Services\RoundService;
use App\Models\Team;

?>

<div>
    {{ view('items/button', ['action' => 'clearData', 'text' => 'Clear all data']) }}
    {{ view('items/button', ['action' => 'generateTeams', 'text' => 'Generate +10 Teams']) }}
    {{ view('items/button', ['action' => 'simulateDivisionGames', 'text' => 'ReSimulate Division Games']) }}

    @foreach (Team::DIVISION_LIST as $division)
        {{ view('tables/divisionTable', ['division' => $division]) }}
    @endforeach


    {{ view('items/button', ['action' => 'simulatePlayOffGames', 'text' => 'ReSimulate Play OFF Games']) }}
    {{ view('tables/roundTable', ['round' => RoundService::ROUND_NAME_PLAY_OFF])  }}

    {{ view('items/button', ['action' => 'simulateSemiFinalGames', 'text' => 'ReSimulate Semi-Final Games']) }}
    {{ view('tables/roundTable', ['round' => RoundService::ROUND_NAME_SEMI_FINAL])  }}

    {{ view('items/button', ['action' => 'simulateFinalGames', 'text' => 'ReSimulate Final Games']) }}
    {{ view('tables/roundTable', ['round' => RoundService::ROUND_NAME_FINAL])  }}
</div>
