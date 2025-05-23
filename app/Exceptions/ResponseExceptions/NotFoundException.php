<?php

namespace App\Exceptions\ResponseExceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends RuntimeException
{
    public function __construct(string $message = 'Register Not Found')
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
