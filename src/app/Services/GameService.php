<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Collection;

class GameService {

    public function clearGames(?string $roundName = null): void
    {
        if (empty($roundName)) {
            Game::truncate();
            return;
        }

        $roundId = RoundService::getIdByName($roundName);
        Game::where('roundId', '>=', $roundId)->delete();
    }

    public function playFirstPlayOffGames(): void
    {
        $teamService = (new TeamService());
        $collectionDivA = $teamService->getDivisionWinners(Team::DIVISION_LIST[0]);
        $collectionDivB = $teamService->getDivisionWinners(Team::DIVISION_LIST[1]);

        $winnersDivA = iterator_to_array($collectionDivA);
        $winnersDivB = iterator_to_array($collectionDivB);
        $winnersDivB = array_reverse($winnersDivB);
        do {
            if (empty($winnersDivA) ||
                empty($winnersDivB)) {
                return;
            }

            $this->playGame(
            RoundService::ROUND_NAME_PLAY_OFF,
                current($winnersDivA),
                current($winnersDivB),
            );

        } while (!empty(next($winnersDivA)) && !empty(next($winnersDivB)));
    }

    public function playLatePlayOffGames($roundName): void
    {
        if (!in_array($roundName, RoundService::LATE_GAME_ROUNDS)) {
            return;
        }
        $winnerList = $this->prepareWinnersForRound($roundName);

        $prevGameWinner = null;
        foreach ($winnerList as $game) {
            if (is_null($prevGameWinner)) {
                $prevGameWinner = $game->winnerId;
                continue;
            }

            (new GameService)->playGame(
                $roundName,
                Team::find($prevGameWinner),
                Team::find($game->winnerId)
            );
            $prevGameWinner = null;
        }
    }

    public function prepareWinnersForRound(string $roundName): ?Collection
    {
        $previousRoundName = (new RoundService())->getPreviousRound($roundName);
        if (empty($previousRoundName)) {
            return null;
        }

        $roundId = RoundService::getIdByName($previousRoundName);
        return $this->getGameListByRoundId($roundId);
    }


    public function playDivisionGames(string $division): void
    {
        $divisionTeamList = Team::where('division', $division)->get();
        $divisionTeams = iterator_to_array($divisionTeamList);

        $teamsPlayed = [];

        foreach ($divisionTeams as $team1) {
            $teamsPlayed[] = $team1->id;

            foreach ($divisionTeams as $team2) {
                if (!in_array($team2->id, $teamsPlayed)) {
                    $this->playGame(RoundService::ROUND_NAME_DIVISION, $team1, $team2);
                }
            }
        }
    }

    public function playGame(string $roundName, Team $team1, Team $team2): void {
        if ($team1->id == $team2->id) {
            return;
        }

        $game = new Game();
        $game->roundId = RoundService::getIdByName($roundName);
        $game->team1Id = $team1->id;
        $game->team2Id = $team2->id;

        while (empty($game->winnerId)) {
            $game->team1Score = rand(0, Game::MAX_SCORE);
            $game->team2Score = rand(0, Game::MAX_SCORE);
            $game->winnerId = $game->getWinnerId();
        }

        $team1->addScore($game->team1Score);
        $team2->addScore($game->team2Score);
        $team1->save();
        $team2->save();
        $game->save();
    }

    public function getViewableGameListByRound(string $roundName): array {
        $roundId = RoundService::getIdByName($roundName);
        return array_map(
            function (Game $game) {
                return $game->getViewableData();
            },
            iterator_to_array(
                $this->getGameListByRoundId($roundId)
            )
        );
    }

    //More beautiful solution will be if models(Game - Team) will be connected between each other
    public function generateReadableScoreMap(string $roundName): array
    {
        $map = [];
        $roundId = RoundService::getIdByName($roundName);
        $games = $this->getGameListByRoundId($roundId);

        foreach (iterator_to_array($games) as $game) {
            /** @var Game $game */

            $map[$game->team1Id][$game->team2Id] = $game->getReadableScore();
            $map[$game->team1Id]['total'] = $game->team1Score + ($map[$game->team1Id]['total'] ?? 0);

            $reverseGame = $game->generateReversePerspectiveGame();
            $map[$reverseGame->team1Id][$reverseGame->team2Id] = $reverseGame->getReadableScore();
        }
        return $map;
    }

    public function getGameListByRoundId(int $roundId): Collection
    {
        return Game::where('roundId', $roundId)->get();
    }
}
