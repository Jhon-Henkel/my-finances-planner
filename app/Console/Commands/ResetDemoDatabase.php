<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronController;
use Illuminate\Console\Command;

class ResetDemoDatabase extends Command
{
    protected $signature = 'reset:demo-database';
    protected $description = 'Reset demo database to default values.';

    public function handle(): void
    {
        $this->info('Resetting demo database...');
        app(CronController::class)->resetDatabaseDemo();
        $this->info('Demo database reset success.');
    }
}
