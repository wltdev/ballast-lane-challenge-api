<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;

class GetAllProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepository) {}

    public function execute()
    {
        try {
            return $this->projectRepository->getAll('id', 'asc');
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
