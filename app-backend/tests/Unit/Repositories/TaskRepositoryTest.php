<?php

use App\Models\Task;
use App\Repositories\Task\TaskRepository;
use Illuminate\Support\Collection;

describe('TaskRepository', function () {
    beforeEach(function () {
        $this->taskMock = mock(Task::class);
        $this->repository = new TaskRepository($this->taskMock);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should create task', function () {
        $taskData = ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending', 'user_id' => 1];

        $this->taskMock->shouldReceive('create')->once()->with($taskData)->andReturn(new Task());

        $task = $this->repository->create($taskData);

        expect($task)->toBeInstanceOf(Task::class);
    });

    it('should return task by id', function () {
        $expectedTask = new Task(['id' => 1]);
        $this->taskMock->shouldReceive('find')->once()->with(1)->andReturn($expectedTask);

        $task = $this->repository->findById(1);

        expect($task)->toBeInstanceOf(Task::class);
    });

    it('should return task by field', function () {
        $expectedTask = new Task(['title' => 'Task 1']);
        $this->taskMock->shouldReceive('where')->once()->with('title', 'Task 1')->andReturnSelf();
        $this->taskMock->shouldReceive('first')->once()->andReturn($expectedTask);

        $task = $this->repository->findByField('title', 'Task 1');

        expect($task)->toBeInstanceOf(Task::class);
    });

    it('should return all tasks', function () {
        $expectedTasks = collect([new Task(['id' => 1]), new Task(['id' => 2])]);
        $this->taskMock->shouldReceive('all')->once()->andReturn($expectedTasks);

        $tasks = $this->repository->getAll();

        expect($tasks)
            ->toBeInstanceOf(Collection::class)
            ->toHaveCount(2);
    });

    it('should update task', function () {
        $taskData = ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending', 'user_id' => 1];

        $this->taskMock->shouldReceive('find')->once()->with(1)->andReturnSelf();
        $this->taskMock->shouldReceive('update')->once()->with($taskData)->andReturn(new Task());

        $task = $this->repository->update(1, $taskData);

        expect($task)->toBeInstanceOf(Task::class);
    });

    it('should delete task', function () {
        $this->taskMock->shouldReceive('find')->once()->with(1)->andReturnSelf();
        $this->taskMock->shouldReceive('delete')->once()->andReturn(true);

        $result = $this->repository->delete(1);

        expect($result)->toBe(true);
    });
});
