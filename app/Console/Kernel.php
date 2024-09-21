<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerateMfpKey::class,
        Commands\GenerateDemoUser::class,
        Commands\GenerateMfpKey::class,
        Commands\MigrateAllTenant::class,
        Commands\MigrateTenant::class,
        Commands\StartDevelopProject::class,
        Commands\CheckSubscription::class
    ];

    /** @codeCoverageIgnore */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('cron:check-subscription')->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
