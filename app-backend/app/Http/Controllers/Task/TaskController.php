<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Services\Task\DeleteTaskService;

class TaskController extends Controller
{
    public function __construct(
        private DeleteTaskService $deleteTaskService
    ) {}


    public function destroy(int $id)
    {
        $record = $this->deleteTaskService->execute($id);

        return response()->json([
            'success' => true,
            'data' => $record
        ], 200);
    }
}
