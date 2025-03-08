<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepositoryInterface;

class UpdateTaskService
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    public function execute(int $id, array $data)
    {
        try {
            return $this->taskRepository->update($id, $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
