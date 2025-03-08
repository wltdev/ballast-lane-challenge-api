<?php

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

describe('UserRepository', function () {
    beforeEach(function () {
        $this->userMock = mock(User::class);
        $this->repository = new UserRepository($this->userMock);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should create user', function () {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];

        $this->userMock->shouldReceive('create')->once()->with($userData)->andReturn(new User());

        $user = $this->repository->create($userData);

        expect($user)->toBeInstanceOf(User::class);
    });

    it('should return user by id', function () {
        $expectedUser = new User(['id' => 1]);
        $this->userMock->shouldReceive('find')->once()->with(1)->andReturn($expectedUser);

        $user = $this->repository->findById(1);

        expect($user)->toBeInstanceOf(User::class);
    });

    it('should return user by field', function () {
        $expectedUser = new User(['email' => 'john@example.com']);
        $this->userMock->shouldReceive('where')->once()->with('email', 'john@example.com')->andReturnSelf();
        $this->userMock->shouldReceive('first')->once()->andReturn($expectedUser);

        $user = $this->repository->findByField('email', 'john@example.com');

        expect($user)->toBeInstanceOf(User::class);
    });

    it('should return all users', function () {
        $expectedUsers = collect([new User(['id' => 1]), new User(['id' => 2])]);
        $this->userMock->shouldReceive('all')->once()->andReturn($expectedUsers);

        $users = $this->repository->getAll();

        expect($users)
            ->toBeInstanceOf(Collection::class)
            ->toHaveCount(2);
    });

    it('should update user', function () {
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'];

        $this->userMock->shouldReceive('find')->once()->with(1)->andReturnSelf();
        $this->userMock->shouldReceive('update')->once()->with($userData)->andReturn(new User());

        $user = $this->repository->update(1, $userData);

        expect($user)->toBeInstanceOf(User::class);
    });

    it('should delete user', function () {
        $this->userMock->shouldReceive('find')->once()->with(1)->andReturnSelf();
        $this->userMock->shouldReceive('delete')->once()->andReturn(true);

        $result = $this->repository->delete(1);

        expect($result)->toBe(true);
    });
});
