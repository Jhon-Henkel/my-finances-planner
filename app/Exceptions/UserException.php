<?php

namespace App\Exceptions;

class UserException extends \RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}