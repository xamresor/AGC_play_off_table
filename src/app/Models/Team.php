<?php

namespace App\Models;

use App\Services\RoundService;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Team extends Model
{
    use HasFactory;

    const DIVISION_WINNERS_AMOUNT = 4;

    //Should be in DB but here to economy time
    const DIVISION_LIST = [
        'A',
        'B',
    ];

    protected $fillable = [
        'name',
        'division',
        'score'
    ];

    public function getScore(): int {
        return $this->score;
    }

    public function setScore(int $score): void {
        $this->score = $score;
    }

    public function addScore(int $score): void {
        $this->setScore($this->score + $score);
    }
}
