<?php

namespace Database\Factories;

use app\Models\Game;
use app\Models\Team;
use App\Services\RoundService;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'roundId' => $this->faker->randomElement(RoundService::GAME_ROUNDS),
            'team1Id' => $this->faker->numberBetween(0, 100),
            'team2Id' => $this->faker->numberBetween(0, 100),
            'team1Score' => $this->faker->numberBetween(0, 5),
            'team2Score' => $this->faker->numberBetween(0, 5),
        ];
    }
}
