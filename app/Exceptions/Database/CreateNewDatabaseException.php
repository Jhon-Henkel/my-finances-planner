<?php

namespace App\Exceptions\Database;

use RuntimeException;

class CreateNewDatabaseException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function throwIfDatabaseNotCreated(string $responseStatus): void
    {
        if ($responseStatus != 'ok') {
            throw new self('Não foi possível criar o banco de dados no servidor!');
        }
    }
}
