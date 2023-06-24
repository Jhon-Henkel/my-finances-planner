<?php

namespace App\Exceptions;

use RuntimeException;

class MovementException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}