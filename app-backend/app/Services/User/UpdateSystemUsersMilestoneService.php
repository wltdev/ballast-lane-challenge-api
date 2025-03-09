<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UpdateSystemUsersMilestoneService
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function execute()
    {
        try {
            $count = $this->userRepository->count();
            $milestoneLevel = floor($count / 100);
            Log::info("Count: {$count}, Milestone Level: {$milestoneLevel}");

            if ($milestoneLevel > 0) {
                $this->userRepository->updateMilestone("milestone {$milestoneLevel}");
                Log::info("Updated milestone: {$milestoneLevel}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to update milestone: {$e->getMessage()}");
        }
    }
}
