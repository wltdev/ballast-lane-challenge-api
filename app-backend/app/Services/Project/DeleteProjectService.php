<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;

class DeleteProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepository) {}

    public function execute(int $id)
    {
        try {
            return $this->projectRepository->delete($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
