<?php

namespace Tests\Feature\Task;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_can_be_created()
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

        // Create a task
        $response = $this->postJson('/api/tasks', [
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => 'pending',
            'user_id' => 1
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task 1',
            'description' => 'Task 1 description',
            'status' => 'pending',
        ]);

        // Response body
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => 1,
                'title' => 'Task 1',
                'description' => 'Task 1 description',
                'status' => 'pending',
                'user_id' => 1
            ]
        ]);
    }
}
