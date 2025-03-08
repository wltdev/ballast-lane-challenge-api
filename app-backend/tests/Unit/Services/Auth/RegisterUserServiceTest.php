<?php

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\Auth\GenerateAccessToken;
use App\Services\Auth\RegisterUserService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

describe('RegisterUserService', function () {
    beforeEach(function () {
        $this->repositoryMock = mock(UserRepository::class);
        $this->generateAccessTokenService = mock(GenerateAccessToken::class);
        $this->service = new RegisterUserService($this->repositoryMock, $this->generateAccessTokenService);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should create user', function () {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];

        $this->repositoryMock->shouldReceive('create')->once()->with($userData)->andReturn(new User());
        $this->generateAccessTokenService
            ->shouldReceive('execute')
            ->once()
            ->with(['email' => $userData['email'], 'password' => $userData['password']])
            ->andReturn(['access_token' => 'token', 'token_type' => 'bearer', 'user' => new User()]);

        $result = $this->service->execute($userData);

        expect($result['status'])->toBe(201);
        expect($result['data']['user'])->toBeInstanceOf(User::class);
    });

    it('should throw exception when database query fails', function () {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];
        $exception = new QueryException('mysql', 'insert into users', [], new \Exception('Duplicate entry'));

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andThrow($exception);

        expect(fn() => $this->service->execute($userData))
            ->toThrow(QueryException::class);
    });

    it('should throw exception when authentication fails', function () {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];
        $exception = new JWTException('Token could not be created');

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andReturn(new User());

        $this->generateAccessTokenService
            ->shouldReceive('execute')
            ->once()
            ->with(['email' => $userData['email'], 'password' => $userData['password']])
            ->andThrow($exception);

        expect(fn() => $this->service->execute($userData))
            ->toThrow(JWTException::class, 'Token could not be created');
    });

    it('should throw exception when token is null', function () {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andReturn(new User());

        $this->generateAccessTokenService
            ->shouldReceive('execute')
            ->once()
            ->with(['email' => $userData['email'], 'password' => $userData['password']])
            ->andReturn(null);

        expect(fn() => $this->service->execute($userData))
            ->toThrow(\Exception::class, 'Failed to authenticate user');
    });
});
