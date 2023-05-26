<?php

namespace App\Console\Commands;

use App\Http\Controllers\CronController;
use Illuminate\Console\Command;

class ResetDemoDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:demodatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset demo database to default values.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting demo database...');
        app(CronController::class)->resetDatabaseDemo();
        $this->info('Demo database reset success.');
    }
}
