<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_be_updated()
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

        // Create a Project
        $responseCreate = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => 1,
            'tasks' => []
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseCreate->assertStatus(201);

        // Update the Project
        $response = $this->putJson('/api/projects/1', [
            'name' => 'Project 1 edited',
            'description' => 'Project 1 description edited',
            'user_id' => 1,
            'tasks' => [
                [
                    'title' => 'Task 1',
                    'status' => 'pending'
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'id' => 1,
            'name' => 'Project 1 edited',
            'description' => 'Project 1 description edited',
            'user_id' => 1
        ]);

        // Response body
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => 1,
                'name' => 'Project 1 edited',
                'description' => 'Project 1 description edited',
                'user_id' => 1,
                'tasks' => [
                    [
                        'id' => 1,
                        'title' => 'Task 1',
                        'status' => 'pending'
                    ]
                ]
            ]
        ]);
    }

    public function test_a_project_cannot_be_updated_without_authentication()
    {
        // Create a Project
        $responseCreate = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => 1,
            'tasks' => []
        ]);

        $responseCreate->assertStatus(401);

        // Update the Project
        $response = $this->putJson('/api/projects/1', [
            'name' => 'Project 1 edited',
            'description' => 'Project 1 description edited',
            'user_id' => 1,
            'tasks' => [
                [
                    'title' => 'Task 1',
                    'status' => 'pending'
                ]
            ]
        ]);

        $response->assertStatus(401);
    }

    public function test_a_project_cannot_be_updated_with_invalid_data()
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

        // Create a Project
        $responseCreate = $this->postJson('/api/projects', [
            'name_invalid' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => 1,
            'tasks' => []
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseCreate->assertStatus(422);
    }
}
