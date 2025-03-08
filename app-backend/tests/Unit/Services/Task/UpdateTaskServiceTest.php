<?php

use App\Models\Task;
use App\Repositories\Task\TaskRepository;
use App\Services\Task\UpdateTaskService;

describe('UpdateTaskServiceTest', function () {
    beforeEach(function () {
        $this->repository = mock(TaskRepository::class);
        $this->service = new UpdateTaskService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should update task', function () {
        $taskId = 1;
        $taskData = ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'in_progress', 'user_id' => 1];

        $this->repository->shouldReceive('update')->once()->with($taskId, $taskData)->andReturn(new Task());

        $task = $this->service->execute($taskId, $taskData);

        expect($task)->toBeInstanceOf(Task::class);
    });

    it('should throw exception when user is not authenticated', function () {
        $taskId = 1;
        $taskData = ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending', 'user_id' => 1];

        expect(fn() => $this->service->execute($taskId, $taskData))
            ->toThrow(\Exception::class);
    });
});
