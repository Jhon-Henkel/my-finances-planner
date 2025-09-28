<?php

namespace App\Infra\Exceptions;

use App\Infra\ErrorReport\ErrorReport;
use App\Infra\Response\Api\ResponseApi;
use App\Infra\Response\Exception\BadRequestException;
use App\Infra\Response\Exception\ForbiddenException;
use App\Infra\Response\Exception\NotFoundException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use InvalidArgumentException;
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
        $this->renderable(function (BadRequestException|DecryptException|InvalidArgumentException $exception) {
            return ResponseApi::renderBadRequest($exception->getMessage());
        });

        $this->renderable(function (ForbiddenException $exception) {
            return ResponseApi::renderForbidden($exception->getMessage());
        });

        $this->renderable(function (NotFoundException $exception) {
            return ResponseApi::renderNotFount();
        });

        $this->renderable(function (UnauthorizedException $e) {
            return ResponseApi::renderUnauthorized($e->getMessage());
        });

        $this->renderable(function (QueryException $exception) {
            ErrorReport::report(new DatabaseException($exception->getMessage()));
            return ResponseApi::renderInternalServerError('Erro ao se conectar com o banco de dados!');
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
