<?php

namespace App\Modules\Movements\Exceptions;

use RuntimeException;

class MovementTypeDontIdentifiedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Tipo de movimento não identificado!');
    }
}
