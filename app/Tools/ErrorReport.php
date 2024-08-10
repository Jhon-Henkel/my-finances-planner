<?php

namespace App\Tools;

use App\Tools\Request\RequestTools;
use Sentry\State\HubInterface;
use Throwable;

class ErrorReport
{
    /** @codeCoverageIgnore */
    public static function report(Throwable $exception): void
    {
        if (RequestTools::isApplicationInDevelopMode()) {
            return;
        }
        if ($exception->getMessage() === 'Tokens obrigatórios ausentes ou inválidos!') {
            return;
        }
        $sentry = app(HubInterface::class);
        $sentry->captureException($exception);
    }
}
