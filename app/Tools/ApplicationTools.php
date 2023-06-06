<?php

namespace App\Tools;

use App\Http\Kernel;

class ApplicationTools
{
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public static function startLaravelApp(): void
    {
        $app = require_once __DIR__ . '/../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
    }
}