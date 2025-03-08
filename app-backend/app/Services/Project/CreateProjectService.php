<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Task\TaskRepositoryInterface;

class CreateProjectService
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository
    ) {}

    public function execute($data)
    {
        try {
            $record = $this->projectRepository->create($data);

            if ($data['tasks'] && count($data['tasks'])) {
                $record->tasks()->createMany($data['tasks']);
            }

            return $record;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
