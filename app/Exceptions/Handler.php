<?php

namespace App\Exceptions;

use App\Enums\Response\StatusCodeEnum;
use App\Exceptions\ResponseExceptions\BadRequestException;
use App\Exceptions\ResponseExceptions\ForbiddenException;
use App\Http\Response\ResponseError;
use App\Tools\ErrorReport;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
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
        BadRequestException::class,
        ForbiddenException::class
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
        $this->renderable(function (BadRequestException|DecryptException $exception) {
            return ResponseError::responseError($exception->getMessage(), StatusCodeEnum::HttpBadRequest->value);
        });

        $this->renderable(function (ForbiddenException $exception) {
            return ResponseError::responseError($exception->getMessage(), StatusCodeEnum::HttpForbidden->value);
        });

        $this->renderable(function (QueryException $exception) {
            ErrorReport::report(new DatabaseException($exception->getMessage()));
            $message = 'Erro ao se conectar com o banco de dados!';
            return ResponseError::responseError($message, StatusCodeEnum::HttpInternalServerError->value);
        });

        $this->reportable(function (Throwable $exception) {
            ErrorReport::report($exception);
        });
    }

    public function report(Throwable $e): void
    {
        ErrorReport::report($e);
        parent::report($e);
    }
}
