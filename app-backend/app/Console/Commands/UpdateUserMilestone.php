<?php

namespace App\Console\Commands;

use App\Services\User\UpdateSystemUsersMilestoneService;
use Illuminate\Console\Command;

class UpdateUserMilestone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-milestone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user milestones';

    public function __construct(private UpdateSystemUsersMilestoneService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->service->execute();
    }
}
