<?php

namespace Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_division_game_simulation_successful_response(): void
    {
        $response = $this->post("/simulateDivisionGames");

        $response->assertStatus(302);
    }

    public function test_the_first_playoff_game_simulation_successful_response(): void
    {
        $response = $this->post("/simulatePlayOffGames");

        $response->assertStatus(302);
    }


    public function test_the_semi_final_game_simulation_successful_response(): void
    {
        $response = $this->post("/simulateSemiFinalGames");

        $response->assertStatus(302);
    }


    public function test_the_final_game_simulation_successful_response(): void
    {
        $response = $this->post("/simulateFinalGames");

        $response->assertStatus(302);
    }

    public function test_all_in_row_game_simulation_successful_responses(): void
    {
        $this->post("/clearData");
        $this->post("/generateTeams");

        $response = $this->post("/simulateDivisionGames");
        $response->assertStatus(302);

        $response = $this->post("/simulatePlayOffGames");
        $response->assertStatus(302);

        $response = $this->post("/simulateSemiFinalGames");
        $response->assertStatus(302);

        $response = $this->post("/simulateFinalGames");
        $response->assertStatus(302);
    }
}
