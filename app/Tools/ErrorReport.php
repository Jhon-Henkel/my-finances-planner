<?php

namespace App\Tools;

use App\Exceptions\Plan\LimitExceededException;
use App\Tools\Request\RequestTools;
use Sentry\State\HubInterface;
use Sentry\State\Scope;
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
        $sentry->configureScope(function (Scope $scope) {
            $scope->setExtra('user_ip', RequestTools::getUserIp());
            $scope->setExtra('user_agent', RequestTools::getUserAgent());
            $scope->setExtra('$_POST', $_POST);
            if (auth()->check()) {
                $user = auth()->user();
                $scope->setUser([
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
            }
        });
        $sentry->captureException($exception);
    }

    protected static function mustIgnoreExceptionByMessage(Throwable $exception): bool
    {
        return match ($exception->getMessage()) {
            'Tokens obrigatórios ausentes ou inválidos!',
            'Service Unavailable',
            'Não é possível excluir uma carteira que possui movimentações!' => true,
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
