<?php

namespace Tests\Unit\Services\GameService;

use App\Models\Game;
use App\Models\Team;
use App\Services\GameService;
use App\Services\RoundService;
use App\Services\TeamService;
use Tests\TestCase;

class PlayDivisionGamesTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_division_game(): void
    {
        $division = Team::DIVISION_LIST[0];
        (new TeamService)->clearData();

        $teamA = Team::factory()->create(['division' => $division]);
        $teamB = Team::factory()->create(['division' => $division]);

        (new GameService())->playDivisionGames($division);

        $this->assertTrue(
            Game::where('team1Id', $teamA->id)->where('team2Id', $teamB->id)
            || Game::where('team2Id', $teamB->id)->where('team1Id', $teamA->id)
        );
    }
}
