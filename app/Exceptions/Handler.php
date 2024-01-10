<?php

namespace App\Exceptions;

use App\Http\Response\ResponseError;
use App\Tools\ErrorReport;
use App\Tools\Request\RequestTools;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
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
        ValueException::class,
        ConstraintException::class,
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
        $this->reportable(function (ValueException $exception) {
            return ResponseError::responseError($exception->getMessage(), ResponseAlias::HTTP_BAD_REQUEST);
        })->stop();

        $this->reportable(function (ConstraintException $exception) {
            return ResponseError::responseError($exception->getMessage(), ResponseAlias::HTTP_BAD_REQUEST);
        })->stop();

        $this->reportable(function (QueryException $exception) {
            ErrorReport::report(new DatabaseException($exception->getMessage()));
            $message = 'Erro ao se conectar com o banco de dados!';
            return ResponseError::responseError($message, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        })->stop();

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