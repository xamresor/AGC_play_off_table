<?php

namespace Tests\Unit\Services\GameService;

use App\Models\Game;
use App\Services\GameService;
use App\Services\RoundService;
use Tests\TestCase;

class ClearDataTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_clear_empty(): void
    {
        $game = Game::factory()->create();
        $this->assertNotEmpty(Game::find($game->id));

        (new GameService())->clearGames();
        $this->assertEmpty(Game::find($game->id));
    }

    public function test_clear_by_round(): void
    {
        $gameDiv = Game::factory()->create([
            'roundId' => RoundService::getIdByName(RoundService::ROUND_NAME_DIVISION)
        ]);
        $gameFin = Game::factory()->create([
            'roundId' => RoundService::getIdByName(RoundService::ROUND_NAME_FINAL)
        ]);

        $this->assertNotEmpty(Game::find($gameDiv->id));
        $this->assertNotEmpty(Game::find($gameFin->id));

        (new GameService())->clearGames(RoundService::ROUND_NAME_FINAL);

        $this->assertNotEmpty(Game::find($gameDiv->id));
        $this->assertEmpty(Game::find($gameFin->id));
    }
}
