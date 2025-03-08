<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;

class GetOneProjectService
{
    public function __construct(private ProjectRepositoryInterface $projectRepository) {}

    public function execute($id)
    {
        try {
            $record = $this->projectRepository->findById($id);

            if (!$record) {
                throw new \Exception('Record not found', 404);
            }

            return $record;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
