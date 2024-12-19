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
        Commands\CheckSubscription::class,
        Commands\OptimizeDatabase::class,
        Commands\OptimizeDatabaseMaster::class,
        Commands\OptimizeDatabaseAll::class,
        Commands\AiInsightPurge::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $this->runAllDaysSchedules($schedule);
        $this->runMondaysSchedules($schedule);
        $this->runThursdaysSchedules($schedule);
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }

    protected function runAllDaysSchedules(Schedule $schedule): void
    {
        $schedule->command('cron:check-subscription')->daily();
    }

    protected function runMondaysSchedules(Schedule $schedule): void
    {
        $schedule->command('telescope:prune')->mondays()->at('00:00');
    }

    protected function runThursdaysSchedules(Schedule $schedule): void
    {
        $schedule->command('app:optimize-database-all')->thursdays()->at('00:00');
        $schedule->command('purge:ai-insight')->thursdays()->at('03:00');
    }
}
