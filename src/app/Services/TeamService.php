<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Collection;

class TeamService {
    public function clearData(): void
    {
        (new GameService())->clearGames();
        Team::truncate();
    }

    public function generateTeams(int $amount = 10): void
    {
        Team::factory($amount)
            ->divisionSequence()
            ->create();
    }

    public function getDivisionWinners(string $division): Collection
    {
        return
            Team::where('division', $division)
            ->take(Team::DIVISION_WINNERS_AMOUNT)
            ->orderBy('score', 'DESC')
            ->get();
    }

    public function getDivisionResultsData(string $division): array
    {

        $scoreMap = (new GameService())->generateReadableScoreMap(RoundService::ROUND_NAME_DIVISION);
        $divisionTeams = Team::all()->where('division', $division);

        return array_map(
            function (Team $team) use ($scoreMap, $divisionTeams) {
                return [
                    'team' => $team,
                    'gameScores' => $this->getTeamScoresInDivisionByTeamList($team->id, $scoreMap, $divisionTeams),
                    'score' => $team->getScore(),
                ];
            } ,
            iterator_to_array($divisionTeams)
        );
    }

    private function getTeamScoresInDivisionByTeamList(
        int $teamId,
        array $scoreMap,
        Collection $opponentList
    ): array {
        $scoreList = [];

        foreach ($opponentList as $opponent) {
            try {
                $scoreList[] = $scoreMap[$teamId][$opponent->id];
            } catch (\Exception $e) {
                $scoreList[] = null;
            }
        }

        return $scoreList;
    }

}
