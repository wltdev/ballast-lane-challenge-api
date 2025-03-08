<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepositoryInterface;

class DeleteTaskService
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    public function execute(int $id)
    {
        try {
            $record = $this->taskRepository->findById($id);

            if (!$record) {
                throw new \Exception('Task not found', 404);
            }

            return $record->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
