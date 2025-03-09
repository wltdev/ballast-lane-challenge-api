<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_be_created()
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

        // Create a project
        $response = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => $user['id'],
            'tasks' => [
                [
                    'title' => 'Project 1',
                    'status' => 'pending',
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => $user['id']
        ]);

        // Response body
        $response->assertJson([
            'success' => true,
            'data' => [
                "name" => "Project 1",
                "description" => "Project 1 description",
                "user_id" => $user['id'],
                "tasks" => [
                    [
                        "title" => "Project 1",
                        "status" => "pending"
                    ]
                ]

            ]
        ]);
    }

    public function test_a_project_cannot_be_created_without_authentication()
    {
        // Create a project
        $response = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => 1
        ]);

        $response->assertStatus(401);
    }

    public function test_a_project_cannot_be_created_with_invalid_data()
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

        // Create a project
        $response = $this->postJson('/api/projects', [
            'name_invalid' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => 1
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422);
    }

    public function test_a_project_cannot_be_created_with_invalid_Project_status()
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

        // Create a project
        $response = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'tasks' => [
                [
                    'title' => 'Project 1',
                    'status' => 'done',
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(422);
    }
}
