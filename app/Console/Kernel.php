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

    protected function schedule(Schedule $schedule): void
    {
        // Todos os dias
        $schedule->command('cron:check-subscription')->daily();

        // Toda segunda-feira
        $schedule->command('telescope:prune')->mondays()->at('00:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
