<?php

use App\Models\Project;
use App\Repositories\Project\ProjectRepository;
use Illuminate\Support\Collection;

describe('ProjectRepository', function () {
    beforeEach(function () {
        $this->projectMock = mock(Project::class);
        $this->repository = new ProjectRepository($this->projectMock);
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

        $project = $this->repository->create($projectData);

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should return project by id', function () {
        $expectedProject = new Project(['id' => 1]);
        $this->projectMock->shouldReceive('find')->once()->with(1)->andReturn($expectedProject);

        $project = $this->repository->findById(1);

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should return project by field', function () {
        $expectedProject = new Project(['name' => 'Project 1']);
        $this->projectMock->shouldReceive('where')->once()->with('name', 'Project 1')->andReturnSelf();
        $this->projectMock->shouldReceive('first')->once()->andReturn($expectedProject);

        $project = $this->repository->findByField('name', 'Project 1');

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should return all projects', function () {
        $expectedProjects = collect([new Project(['id' => 1]), new Project(['id' => 2])]);

        $this->projectMock->shouldReceive('get')->once()->andReturn($expectedProjects);

        $projects = $this->repository->getAll();

        expect($projects)
            ->toBeInstanceOf(Collection::class)
            ->toHaveCount(2);
    });

    it('should update project', function () {
        $projectData = [
            'name' => 'Project 1',
            'description' => 'Description 1',
            'user_id' => 1,
            'tasks' => []
        ];

        $this->projectMock->shouldReceive('find')->once()->with(1)->andReturnSelf();
        $this->projectMock->shouldReceive('update')->once()->with($projectData)->andReturn(new Project());

        $project = $this->repository->update(1, $projectData);

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should delete project', function () {
        $this->projectMock->shouldReceive('find')->once()->with(1)->andReturnSelf();
        $this->projectMock->shouldReceive('delete')->once()->andReturn(true);

        $result = $this->repository->delete(1);

        expect($result)->toBe(true);
    });
});
