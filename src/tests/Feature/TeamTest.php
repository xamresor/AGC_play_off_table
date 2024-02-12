<?php

namespace Feature;

use Tests\TestCase;

class TeamTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_teams_clear_data(): void
    {
        $response = $this->post("/clearData");

        $response->assertStatus(302);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->post("/generateTeams");

        $response->assertStatus(302);
    }
}
