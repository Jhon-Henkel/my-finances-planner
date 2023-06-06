<?php

namespace App\Exceptions;

use App\Tools\ErrorReport;
use App\Tools\RequestTools;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $exception) {
            ErrorReport::report($exception);
        });
    }

    public function report(Throwable $e): void
    {
        if (app()->bound('honeybadger') && $this->shouldReport($e)) {
            if (RequestTools::isApplicationInDevelopMode()) {
                return;
            }
            app('honeybadger')->notify($e, app('request'));
        }
        parent::report($e);
    }
}