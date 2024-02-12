<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Game extends Model
{
    use HasFactory;

    const MAX_SCORE = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'roundId',
        'team1Id',
        'team2Id',
        'winnerId',
        'team1Score',
        'team2Score',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    public function getWinnerId(): ?int {
        if ($this->team1Score > $this->team2Score) {
            return $this->team1Id;
        }
        if ($this->team1Score < $this->team2Score) {
            return $this->team2Id;
        }
        return null;
    }

    public function generateReversePerspectiveGame(): self {
        $game = clone $this;
        $game->team1Id = $this->team2Id;
        $game->team2Id = $this->team1Id;
        $game->team1Score = $this->team2Score;
        $game->team2Score = $this->team1Score;

        return $game;
    }

    public function getReadableScore(): string {
        return "{$this->team1Score} - {$this->team2Score}";
    }

    public function getViewableData(): array
    {
        $teamA = Team::find($this->team1Id);
        $teamB = Team::find($this->team2Id);
        $winner = Team::find($this->winnerId) ?? '-';

        return [
            'teamAName' => $teamA->name,
            'teamBName' => $teamB->name,
            'score' => $this->getReadableScore(),
            'winnerName' => $winner->name,
        ];
    }
}
