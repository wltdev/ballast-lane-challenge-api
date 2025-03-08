<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
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

        $user = User::where('email', 'john@example.com')->first();

        $this->assertNotNull($user);

        // Response body
        $response->assertJson([
            'success' => true,
            'data' => [
                'access_token' => true,
                'token_type' => 'bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at->toIsoString(),
                    'updated_at' => $user->updated_at->toIsoString()
                ]
            ]
        ]);
    }

    public function test_a_user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '12345',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);

        // Assert errors
        $response->assertJsonValidationErrors([
            'password',
            'password_confirmation'
        ]);
    }

    public function test_a_user_cannot_register_with_duplicate_email()
    {
        // Register a user
        $this->test_a_user_can_register();

        // try to register with the same email
        $response = $this->postJson('/api/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);

        // Assert errors
        $response->assertJsonValidationErrors([
            'email'
        ]);
    }
}
