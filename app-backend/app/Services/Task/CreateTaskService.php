<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepositoryInterface;

class CreateTaskService
{
    public function __construct(private TaskRepositoryInterface $taskRepository) {}

    public function execute($data)
    {
        try {
            return $this->taskRepository->create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
