<?php

namespace App\Tools;

use App\Http\Kernel;

class AppTools
{
    /** @codeCoverageIgnore */
    public static function startLaravelApp(): void
    {
        $app = require_once __DIR__ . '/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
    }

    /** @codeCoverageIgnore */
    public static function getEnvValue(string $key): string
    {
        return env($key);
    }
}