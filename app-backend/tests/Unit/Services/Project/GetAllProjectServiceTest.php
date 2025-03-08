<?php

use App\Models\Project;
use App\Repositories\Project\ProjectRepository;
use App\Services\Project\GetAllProjectService;
use Illuminate\Support\Collection;

describe('GetAllProjectServiceTest', function () {
    beforeEach(function () {
        $this->repository = mock(ProjectRepository::class);
        $this->service = new GetAllProjectService($this->repository);
    });

    afterEach(function () {
        Mockery::close();
    });

    it('should get all projects', function () {
        $projects = collect([new Project(), new Project()]);

        $this->repository->shouldReceive('getAll')->once()->andReturn($projects);

        $result = $this->service->execute();

        expect($result)->toBeInstanceOf(Collection::class);
        expect($result->first())->toBeInstanceOf(Project::class);
    });
});
