<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerateMfpKey::class,
        Commands\GenerateDemoUser::class,
    ];

    /** @codeCoverageIgnore */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->exec('php ' . base_path('artisan') . ' reset:demodatabase');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
