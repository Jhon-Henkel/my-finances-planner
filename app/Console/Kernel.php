<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ResetDemoDatabase::class,
        Commands\GenerateMfpKey::class,
        Commands\GenerateDemoUser::class,
    ];

    /**
     * @codeCoverageIgnore
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->exec( 'php ' . base_path('artisan') . ' reset:demodatabase' );
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
