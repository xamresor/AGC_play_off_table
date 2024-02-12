<?php

namespace Database\Factories;

use app\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'division' => $this->faker->randomElement(Team::DIVISION_LIST),
            'score' => $this->faker->numberBetween(0,5),
        ];
    }

    public function divisionSequence()
    {

        $sequence = array_map(function ($value) {
                return ['division' => $value];
            },
            Team::DIVISION_LIST
        );
        return $this->sequence(...$sequence);
    }


}
