<?php

namespace App\Exceptions\ResponseExceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ForbiddenException extends RuntimeException
{
    public function __construct(string $message = 'Forbidden')
    {
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }
}