<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_be_retrieved()
    {
        // Login the user
        $responseUser = $this->postJson('/api/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $responseUser->assertStatus(201);

        // get user token from response
        $token = $responseUser->json('data.access_token');
        $user = $responseUser->json('data.user');

        // Create a Project
        $responseCreate = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => $user['id'],
            'tasks' => []
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseCreate->assertStatus(201);
        $project = $responseCreate->json('data');

        $this->assertDatabaseHas('projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => $user['id']
        ]);

        // Get one Project
        $response = $this->getJson('/api/projects/' . $project['id'], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        // Response body
        $response->assertJson([
            'success' => true,
            'data' => [
                'name' => 'Project 1',
                'description' => 'Project 1 description',
                'user_id' => $user['id'],
                'tasks' => []
            ]
        ]);
    }

    public function test_project_not_found()
    {
        // Login the user
        $responseUser = $this->postJson('/api/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $responseUser->assertStatus(201);

        // get user token from response
        $token = $responseUser->json('data.access_token');

        // Get one Project
        $response = $this->getJson('/api/projects/1', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(404);
    }
}
