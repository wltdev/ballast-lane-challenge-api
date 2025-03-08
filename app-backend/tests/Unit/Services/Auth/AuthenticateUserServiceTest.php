<?php

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Auth\AuthenticateUserService;
use App\Services\Auth\GenerateAccessToken;

describe('AuthenticateUserService', function () {
    beforeEach(function () {
        $this->repositoryMock = mock(UserRepository::class);
        $this->generateAccessTokenMock = mock(GenerateAccessToken::class);
        $this->service = new AuthenticateUserService($this->repositoryMock, $this->generateAccessTokenMock);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should authenticate user', function () {
        $data = [
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $this->repositoryMock->shouldReceive('findByField')
            ->once()
            ->with('email', $data['email'])
            ->andReturn(new User());

        $this->generateAccessTokenMock
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn([
                'access_token' => 'token',
                'token_type' => 'bearer',
                'user' => new User()
            ]);

        $result = $this->service->execute($data);

        expect($result['status'])->toBe(200);
        expect($result['data']['user'])->toBeInstanceOf(User::class);
    });

    it('should throw exception when user not found', function () {
        $data = [
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $this->repositoryMock->shouldReceive('findByField')
            ->once()
            ->with('email', $data['email'])
            ->andReturn(null);

        expect(fn() => $this->service->execute($data))
            ->toThrow(\Exception::class, 'User not found');
    });

    it('should throw exception when authentication fails', function () {
        $data = [
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $this->repositoryMock->shouldReceive('findByField')
            ->once()
            ->with('email', $data['email'])
            ->andReturn(new User());

        $this->generateAccessTokenMock
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn(null);

        expect(fn() => $this->service->execute($data))
            ->toThrow(\Exception::class, 'Failed to authenticate user');
    });
});
