<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function count()
    {
        return $this->model->count();
    }

    public function updateMilestone(string $milestoneLevel)
    {
        return $this->model->whereNull('milestone')->update(['milestone' => $milestoneLevel]);
    }
}
