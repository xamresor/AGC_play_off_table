<?php

namespace App\Services;

class RoundService {

    const ROUND_NAME_DIVISION = 'division';
    const ROUND_NAME_PLAY_OFF = 'playOff';
    const ROUND_NAME_SEMI_FINAL = 'semiFinal';
    const ROUND_NAME_FINAL = 'final';

    const GAME_ROUNDS = [
        self::ROUND_NAME_DIVISION => 1,
        self::ROUND_NAME_PLAY_OFF => 2,
        self::ROUND_NAME_SEMI_FINAL => 3,
        self::ROUND_NAME_FINAL => 4,
    ];

    const LATE_GAME_ROUNDS = [
        self::ROUND_NAME_SEMI_FINAL,
        self::ROUND_NAME_FINAL,
    ];

    public static function getIdByName(string $name): int
    {
        return self::GAME_ROUNDS[$name] ?? 0;
    }

    public static function getPreviousRound(string $name): ?string
    {
        $id = self::getIdByName($name);
        return array_flip(self::GAME_ROUNDS)[$id-1] ?? null;
    }

}
