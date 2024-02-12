<?php
namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Services\GameService;
use App\Services\RoundService;
use App\Services\TeamService;
use Exception;

class GameController extends Controller
{
    private GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function simulateDivisionGames() {
        $this->gameService->clearGames();
        foreach (Team::DIVISION_LIST as $division) {
            $this->gameService->playDivisionGames($division);
        }

        return back()->withInput();
    }

    public function simulatePlayOffGames() {
        $this->gameService->clearGames(RoundService::ROUND_NAME_PLAY_OFF);
        $this->gameService->playFirstPlayOffGames();

        return back()->withInput();
    }

    public function simulateSemiFinalGames() {
        $this->gameService->clearGames(RoundService::ROUND_NAME_SEMI_FINAL);
        $this->gameService->playLatePlayOffGames(RoundService::ROUND_NAME_SEMI_FINAL);
        return back()->withInput();
    }

    public function simulateFinalGames() {
        $this->gameService->clearGames(RoundService::ROUND_NAME_FINAL);
        $this->gameService->playLatePlayOffGames(RoundService::ROUND_NAME_FINAL);
        return back()->withInput();
    }
}
