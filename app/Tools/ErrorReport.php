<?php

namespace App\Tools;

use App\Exceptions\Plan\LimitExceededException;
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
        if (self::mustIgnoreExceptionByMessage($exception)) {
            return;
        }
        if (self::mustIgnoreExceptionByInstance($exception)) {
            return;
        }
        $sentry = app(HubInterface::class);
        $sentry->captureException($exception);
    }

    protected static function mustIgnoreExceptionByMessage(Throwable $exception): bool
    {
        return match ($exception->getMessage()) {
            'Tokens obrigatórios ausentes ou inválidos!',
            'Service Unavailable' => true,
            default => false,
        };
    }

    protected static function mustIgnoreExceptionByInstance(Throwable $exception): bool
    {
        return match (get_class($exception)) {
            LimitExceededException::class => true,
            default => false,
        };
    }
}
