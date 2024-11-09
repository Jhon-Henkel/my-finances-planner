<?php

namespace App\Modules\SpendingPlan\Exceptions;

use App\Exceptions\ResponseExceptions\BadRequestException;

class MonthQueryParamMissingException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct("Parâmetro 'month' é obrigatório");
    }
}
