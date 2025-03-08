<?php

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Project\ProjectRepository;
use App\Services\Project\CreateProjectService;
use Illuminate\Support\Facades\Auth;

describe('CreateProjectService', function () {
    beforeEach(function () {
        $this->projectMock = mock(Project::class);
        $this->repository = new ProjectRepository($this->projectMock);
        $this->service = new CreateProjectService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should create project', function () {
        $projectData = [
            'name' => 'Project 1',
            'description' => 'Description 1',
            'user_id' => 1,
            'tasks' => []
        ];

        $this->projectMock->shouldReceive('create')->once()->with($projectData)->andReturn(new Project());

        $project = $this->service->execute($projectData);

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should create project and tasks', function () {
        $projectData = [
            'name' => 'Project 1',
            'description' => 'Description 1',
            'user_id' => 1,
            'tasks' => [
                ['title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending'],
                ['title' => 'Task 2', 'description' => 'Description 2', 'status' => 'in_progress']
            ]
        ];

        $tasksMock = mock(Task::class);
        $this->projectMock->shouldReceive('create')->once()->with($projectData)->andReturnSelf();
        $this->projectMock->shouldReceive('tasks')->once()->andReturn($tasksMock);
        $tasksMock->shouldReceive('createMany')->once()->with($projectData['tasks'])->andReturn(collect());

        $project = $this->service->execute($projectData);

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should throw exception when user is not authenticated', function () {
        $projectData = ['name' => 'Project 1', 'description' => 'Description 1', 'user_id' => 1];

        expect(fn() => $this->service->execute($projectData))
            ->toThrow(\Exception::class);
    });
});
