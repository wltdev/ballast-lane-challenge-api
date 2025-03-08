<?php

use App\Models\Project;
use App\Repositories\Project\ProjectRepository;
use App\Services\Project\GetOneProjectService;

describe('GetOneProjectServiceTest', function () {
    beforeEach(function () {
        $this->repository = mock(ProjectRepository::class);
        $this->service = new GetOneProjectService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should get one project', function () {
        $project = new Project();

        $this->repository->shouldReceive('findById')->once()->andReturn($project);

        $project = $this->service->execute(1);

        expect($project)->toBeInstanceOf(Project::class);
    });

    it('should throw exception when project is not found', function () {
        $this->repository->shouldReceive('findById')->once()->andReturn(null);

        expect(fn() => $this->service->execute(1))
            ->toThrow(\Exception::class);
    });
});
