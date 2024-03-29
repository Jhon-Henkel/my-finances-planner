<?php

namespace App\Tools;

use App\Tools\Request\RequestTools;
use Throwable;

class ErrorReport
{
    /** @codeCoverageIgnore */
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