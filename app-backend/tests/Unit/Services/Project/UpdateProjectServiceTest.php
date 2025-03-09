<?php

use App\Models\Project;
use App\Models\Task;
use App\Repositories\Project\ProjectRepository;
use App\Services\Project\UpdateProjectService;


describe('UpdateProjectServiceTest', function () {
    beforeEach(function () {
        $this->repository = mock(ProjectRepository::class);
        $this->service = new UpdateProjectService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should update project', function () {
        $projectId = 1;
        $projectData = [
            'name' => 'Project 1',
            'description' => 'Description 1',
            'user_id' => 1,
            'tasks' => [
                ['id' => 1, 'title' => 'Task 1', 'description' => 'Description 1', 'status' => 'pending'],
                ['title' => 'Task 2', 'description' => 'Description 2', 'status' => 'in_progress']
            ]
        ];

        // Create a mock project with tasks relationship
        $project = mock(Project::class);
        $tasksRelation = mock(Task::class);

        // Setup the mocks
        $this->repository->shouldReceive('findById')
            ->once()
            ->with($projectId)
            ->andReturn($project);

        $project->shouldReceive('update')
            ->once()
            ->with(Mockery::subset($projectData))
            ->andReturnSelf();

        $project->shouldReceive('tasks')
            ->times(3)
            ->andReturn($tasksRelation);

        // whereNotIn
        $tasksRelation->shouldReceive('whereNotIn')
            ->once()
            ->with('id', array_column($projectData['tasks'], 'id'))
            ->andReturnSelf();
        $tasksRelation->shouldReceive('delete')
            ->once();

        // Mock task 1 update
        $task1 = mock(Task::class);
        $tasksRelation->shouldReceive('where')
            ->once()
            ->with('id', 1)
            ->andReturnSelf();
        $tasksRelation->shouldReceive('first')
            ->once()
            ->andReturn($task1);
        $task1->shouldReceive('update')
            ->once()
            ->with(Mockery::subset($projectData['tasks'][0]))
            ->andReturnSelf();

        // Mock task 2 creation
        $task2 = mock(Task::class);
        $tasksRelation->shouldReceive('create')
            ->once()
            ->with(Mockery::subset($projectData['tasks'][1]))
            ->andReturn($task2);

        $result = $this->service->execute($projectId, $projectData);

        expect($result)->toBe($project);
    });

    it('should throw exception when project is not found', function () {
        $projectId = 1;
        $projectData = ['name' => 'Project 1', 'description' => 'Description 1', 'user_id' => 1];

        $this->repository->shouldReceive('findById')
            ->once()
            ->with($projectId)
            ->andReturn(null);

        expect(fn() => $this->service->execute($projectId, $projectData))
            ->toThrow(\Exception::class, 'Project not found');
    });
});
