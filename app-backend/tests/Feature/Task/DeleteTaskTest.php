<?php

namespace Tests\Feature\Task;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_can_be_deleted()
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

        // create a project with task
        $responseCreate = $this->postJson('/api/projects', [
            'name' => 'Project 1',
            'description' => 'Project 1 description',
            'user_id' => 1,
            'tasks' => [
                ['id' => 1, 'title' => 'Task 1', 'description' => 'Task 1 description', 'status' => 'pending'],
            ]
        ], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $responseCreate->assertStatus(201);

        // Delete the task
        $response = $this->deleteJson('/api/tasks/1', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'id' => 1
        ]);
    }
}
