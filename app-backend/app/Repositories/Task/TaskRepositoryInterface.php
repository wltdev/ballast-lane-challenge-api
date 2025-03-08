<?php

namespace App\Repositories\Task;

use App\Repositories\BaseRepositoryInterface;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{
    public function createMany(array $data): void;
}
