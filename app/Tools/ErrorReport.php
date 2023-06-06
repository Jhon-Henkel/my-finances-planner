<?php

namespace App\Tools;

use Sentry\Laravel\Integration;
use Throwable;

class ErrorReport
{
    public static function report(Throwable $exception): void
    {
        if (RequestTools::isApplicationInDevelopMode()) {
            return;
        }
        if (app()->bound('honeybadger')) {
            app('honeybadger')->notify($exception, app('request'));
        }
    }
}