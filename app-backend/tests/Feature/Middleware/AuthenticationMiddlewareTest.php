<?php

namespace Tests\Feature\Middleware;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);
    }

    public function test_request_with_valid_token_succeeds()
    {
        $token = JWTAuth::fromUser($this->user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');

        $response->assertStatus(200);
    }

    public function test_request_without_token_fails()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401)
            ->assertJson(['error' => 'Token not found']);
    }

    public function test_request_with_invalid_token_fails()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid.token.here',
        ])->getJson('/api/me');

        $response->assertStatus(401)
            ->assertJson(['error' => 'Invalid token']);
    }

    public function test_request_with_token_for_nonexistent_user_fails()
    {
        $token = JWTAuth::fromUser($this->user);
        $this->user->delete();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');

        $response->assertStatus(401)
            ->assertJson(['error' => 'User not found']);
    }

    public function test_request_with_expired_token_fails()
    {
        // Mock JWTAuth to return a valid token but throw TokenExpiredException
        $token = 'fake_expired_token';

        JWTAuth::shouldReceive('getToken')->once()->andReturn($token);
        JWTAuth::shouldReceive('manager')->andReturnSelf();
        JWTAuth::shouldReceive('decode')->andThrow(new \Tymon\JWTAuth\Exceptions\TokenExpiredException());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/me');

        $response->assertStatus(401)
            ->assertJson(['error' => 'Token expired']);
    }
}
