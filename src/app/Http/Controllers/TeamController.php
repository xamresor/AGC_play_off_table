<?php
namespace App\Http\Controllers;

use App\Services\GameService;
use App\Services\TeamService;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    private TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }
    public function clearData(): RedirectResponse {
        $this->teamService->clearData();
        return back()->withInput();
    }

    public function generateTeams(): RedirectResponse {
        $this->teamService->generateTeams(10);
        return back()->withInput();
    }
}
