<?php

namespace App\Tools;

use Throwable;

class ErrorReport
{
    /**
     * @codeCoverageIgnore
     * @param Throwable $exception
     * @return void
     */
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