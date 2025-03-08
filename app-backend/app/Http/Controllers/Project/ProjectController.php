<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\Project\CreateProjectService;
use App\Services\Project\GetAllProjectService;
use App\Services\Project\GetOneProjectService;
use App\Services\Project\UpdateProjectService;


class ProjectController extends Controller
{
    public function __construct(
        private CreateProjectService $createProjectService,
        private UpdateProjectService $updateProjectService,
        private GetAllProjectService $getAllProjectService,
        private GetOneProjectService $getOneProjectService
    ) {}

    public function index()
    {
        $records = $this->getAllProjectService->execute();

        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($records)
        ], 200);
    }

    public function show(int $id)
    {
        $record = $this->getOneProjectService->execute($id);

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($record)
        ], 200);
    }

    public function store(CreateProjectRequest $request)
    {
        $record = $this->createProjectService->execute($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($record)
        ], 201);
    }

    public function update(UpdateProjectRequest $request, int $id)
    {
        $record = $this->updateProjectService->execute($id, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($record)
        ], 200);
    }
}
