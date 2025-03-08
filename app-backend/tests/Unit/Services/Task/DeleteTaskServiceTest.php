<?php

use App\Models\Task;
use App\Repositories\Task\TaskRepository;
use App\Services\Task\DeleteTaskService;

describe('DeleteTaskServiceTest', function () {
    beforeEach(function () {
        $this->repository = mock(TaskRepository::class);
        $this->service = new DeleteTaskService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should delete Task', function () {
        $taskId = 1;

        $taskMock = mock(Task::class);

        $this->repository->shouldReceive('findById')->once()->with($taskId)->andReturn($taskMock);
        $taskMock->shouldReceive('delete')->once()->andReturn(true);

        $task = $this->service->execute($taskId);

        expect($task)->toBe(true);
    });

    it('should throw exception when Task is not found', function () {
        $taskId = 1;

        $this->repository->shouldReceive('findById')->once()->with($taskId)->andReturn(null);

        expect(fn() => $this->service->execute($taskId))
            ->toThrow(\Exception::class);
    });
});
