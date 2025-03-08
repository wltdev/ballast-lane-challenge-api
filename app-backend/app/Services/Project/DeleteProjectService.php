<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;

class DeleteProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepository) {}

    public function execute(int $id)
    {
        try {
            $record = $this->projectRepository->findById($id);

            if (!$record) {
                throw new \Exception('Project not found', 404);
            }

            return $record->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
