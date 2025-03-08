<?php

use App\Models\Task;
use App\Models\User;
use App\Repositories\Task\TaskRepository;
use App\Services\Task\CreateTaskService;
use Illuminate\Support\Facades\Auth;

describe('CreateTaskService', function () {
    beforeEach(function () {
        $this->taskMock = mock(Task::class);
        $this->repository = new TaskRepository($this->taskMock);
        $this->service = new CreateTaskService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should create task', function () {
        $taskData = ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending', 'user_id' => 1];

        $this->taskMock->shouldReceive('create')->once()->with($taskData)->andReturn(new Task());

        $task = $this->service->execute($taskData);

        expect($task)->toBeInstanceOf(Task::class);
    });

    it('should throw exception when user is not authenticated', function () {
        $taskData = ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending', 'user_id' => 1];

        expect(fn() => $this->service->execute($taskData))
            ->toThrow(\Exception::class);
    });
});
