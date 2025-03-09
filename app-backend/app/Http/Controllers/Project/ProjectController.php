<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\Project\CreateProjectService;
use App\Services\Project\DeleteProjectService;
use App\Services\Project\GetAllProjectService;
use App\Services\Project\GetOneProjectService;
use App\Services\Project\UpdateProjectService;

/**
 * @OA\Tag(
 *     name="Projects",
 *     description="API Endpoints of Projects"
 * )
 */
class ProjectController extends Controller
{
    public function __construct(
        private CreateProjectService $createProjectService,
        private UpdateProjectService $updateProjectService,
        private GetAllProjectService $getAllProjectService,
        private GetOneProjectService $getOneProjectService,
        private DeleteProjectService $deleteProjectService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/projects",
     *     operationId="getProjects",
     *     tags={"Projects"},
     *     security={"bearerAuth": {}},
     *     summary="Get all projects",
     *     description="Returns all projects for the authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="Projects retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Project")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index()
    {
        $records = $this->getAllProjectService->execute();

        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($records)
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     operationId="getProject",
     *     tags={"Projects"},
     *     security={"bearerAuth": {}},
     *     summary="Get a project",
     *     description="Returns a specific project by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Project ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Project")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show(int $id)
    {
        $record = $this->getOneProjectService->execute($id);

        return response()->json([
            'success' => true,
            'data' => new ProjectResource($record)
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     operationId="storeProject",
     *     tags={"Projects"},
     *     security={"bearerAuth": {}},
     *     summary="Create a new project",
     *     description="Creates a new project for the authenticated user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Project created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Project")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(CreateProjectRequest $request)
    {
        $record = $this->createProjectService->execute($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => new ProjectResource($record)
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     operationId="updateProject",
     *     tags={"Projects"},
     *     security={"bearerAuth": {}},
     *     summary="Update a project",
     *     description="Updates a specific project by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Project ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Project updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Project")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        $record = $this->updateProjectService->execute($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => new ProjectResource($record)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     operationId="deleteProject",
     *     tags={"Projects"},
     *     security={"bearerAuth": {}},
     *     summary="Delete a project",
     *     description="Deletes a specific project by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Project ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Project deleted successfully"),
     *             @OA\Property(property="data", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $record = $this->deleteProjectService->execute($id);

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully',
            'data' => $record
        ], 200);
    }
}
