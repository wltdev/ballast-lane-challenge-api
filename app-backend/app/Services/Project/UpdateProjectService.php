<?php

namespace App\Services\Project;

use App\Models\Project;
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

            if (isset($data['tasks']) && count($data['tasks'])) {
                $this->handleTasks($record, $data);
            }

            return $record;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function handleTasks(Project $record, array $data): void
    {
        // tasks to delete
        $record->tasks()->whereNotIn('id', array_column($data['tasks'], 'id'))->delete();

        // create or update tasks
        foreach ($data['tasks'] as $task) {
            if (isset($task['id'])) {
                $hasTask = $record->tasks()->where('id', $task['id'])->first();
                if ($hasTask) {
                    $hasTask->update($task);
                }
            } else {
                $record->tasks()->create($task);
            }
        }
    }
}
