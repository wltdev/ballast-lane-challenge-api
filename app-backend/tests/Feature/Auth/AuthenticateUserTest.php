<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_a_user_can_authenticate()
    {
        // Register a user
        $this->test_a_user_can_register();

        // Authenticate the user
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);

        // Response body
        $response->assertJson([
            'success' => true,
            'data' => [
                'access_token' => true,
                'token_type' => 'bearer',
                'user' => [
                    'id' => 1,
                    'name' => 'John',
                    'email' => 'john@example.com'
                ]
            ]
        ]);
    }

    public function test_a_user_cannot_authenticate_with_invalid_credentials()
    {
        // Register a user
        $this->test_a_user_can_register();

        // Authenticate the user with invalid credentials
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);

        // Response body
        $response->assertJson([
            'success' => false,
            'errors' => 'Failed to authenticate user'
        ]);
    }

    public function test_a_user_cannot_authenticate_with_invalid_email()
    {
        // Register a user
        // $this->test_a_user_can_register();

        // Authenticate the user with invalid email
        $response = $this->postJson('/api/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
    }
}
