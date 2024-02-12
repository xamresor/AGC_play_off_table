<?php

use App\Services\GameService;

$list = (new GameService)->getViewableGameListByRound($round ?? '');
?>

<div class="resultList">

    @foreach ($list as $key =>$game)
        {{ view("tables/twoTeamTable", $game) }}
        @if(!(($key + 1) % 7))
            <br>
        @endif
    @endforeach

</div>
