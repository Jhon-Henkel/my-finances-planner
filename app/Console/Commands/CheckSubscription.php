<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Queue\QueueMessagesService;
use Illuminate\Console\Command;

class CheckSubscription extends Command
{
    protected $signature = 'cron:check-subscription';
    protected $description = 'Cron to check subscription and update user subscription status';

    public function __construct(private readonly QueueMessagesService $queueMessagesService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();

        foreach (User::all() as $user) {
            $this->queueMessagesService->putMessageCheckSubscription($user->email);
        }
        $this->info('Cron job executado com sucesso!');
    }
}
