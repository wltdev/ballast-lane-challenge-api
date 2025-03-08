<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\Task\CreateTaskService;
use App\Services\Task\UpdateTaskService;


class TaskController extends Controller
{
    public function __construct(
        private CreateTaskService $createTaskService,
        private UpdateTaskService $updateTaskService
    ) {}

    public function index()
    {
        return [];
    }

    public function store(CreateTaskRequest $request)
    {
        try {
            $record = $this->createTaskService->execute($request->validated());

            return response()->json([
                'success' => true,
                'data' => $record
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(UpdateTaskRequest $request, int $id)
    {
        try {
            $record = $this->updateTaskService->execute($id, $request->validated());

            return response()->json([
                'success' => true,
                'data' => $record
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
