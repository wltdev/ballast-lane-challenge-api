<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function count();
    public function updateMilestone(string $milestoneLevel);
}
