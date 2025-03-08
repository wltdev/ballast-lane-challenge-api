<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;

class UpdateProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepository) {}

    public function execute(int $id, array $data)
    {
        try {
            $record = $this->projectRepository->findById($id);

            if (!$record) {
                throw new \Exception('Project not found', 404);
            }

            $record->update($data);

            if ($data['tasks'] && count($data['tasks'])) {
                // create or update tasks
                foreach ($data['tasks'] as $task) {

                    if (isset($task['id'])) {
                        $hasTask = $record->tasks()->where('id', $task['id'])->first();
                        $hasTask->update($task);
                    } else {
                        $record->tasks()->create($task);
                    }
                }
            }

            return $record;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
