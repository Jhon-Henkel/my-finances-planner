<?php

namespace App\Exceptions;

use RuntimeException;

class CountGainAndExpenseDataGraphException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Contagem de total de ganhos e total de gastos divergente.');
    }
}