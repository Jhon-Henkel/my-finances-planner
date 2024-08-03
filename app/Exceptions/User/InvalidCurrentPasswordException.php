<?php

namespace App\Exceptions\User;

use App\DTO\UserDTO;
use App\Exceptions\ResponseExceptions\ForbiddenException;

class InvalidCurrentPasswordException extends ForbiddenException
{
    public function __construct()
    {
        parent::__construct('A senha atual não confere!');
    }

    public static function throwIfPasswordDontMatch(UserDTO $alterUser, UserDTO $dbUser): void
    {
        if (! password_verify($alterUser->getCurrentPassword(), $dbUser->getPassword())) {
            throw new self();
        }
    }
}