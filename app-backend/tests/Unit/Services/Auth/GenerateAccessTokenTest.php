<?php

use App\Models\User;
use App\Services\Auth\GenerateAccessToken;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

describe('GenerateAccessToken', function () {
    beforeEach(function () {
        $this->service = new GenerateAccessToken();
    });

    it('should generate token with valid credentials', function () {
        $credentials = ['email' => 'john@example.com', 'password' => 'password123'];
        $user = new User(['email' => 'john@example.com']);
        $token = 'fake_jwt_token';

        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn($token);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $result = $this->service->execute($credentials);

        expect($result)->toBeArray()
            ->toHaveKeys(['access_token', 'token_type', 'user'])
            ->access_token->toBe($token)
            ->token_type->toBe('bearer')
            ->and($result['user'])->toBeInstanceOf(User::class);
    });

    it('should throw exception when authentication fails', function () {
        $credentials = ['email' => 'john@example.com', 'password' => 'password123'];
        $exception = new JWTException('Token could not be created');

        Auth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andThrow($exception);

        expect(fn() => $this->service->execute($credentials))
            ->toThrow(JWTException::class, 'Token could not be created');
    });
});
