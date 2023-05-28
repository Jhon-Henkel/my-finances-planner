<?php

namespace App\Tools;

use Sentry\Laravel\Integration;
use Throwable;

class ErrorReport
{
    public static function report(Throwable $e): void
    {
        if (RequestTools::isApplicationInDevelopMode()) {
            return;
        }
        Integration::captureUnhandledException($e);
    }
}