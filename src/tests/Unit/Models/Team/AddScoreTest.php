<?php

namespace Tests\Unit\Models\Team;

use App\Models\Team;
use Tests\TestCase;

class AddScoreTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_add_score(): void
    {
        $team = Team::factory()->create();

        $score = $team->score;
        $number = 2;

        $team->addScore($number);

        $this->assertEquals($score + $number, $team->score);
    }
}
