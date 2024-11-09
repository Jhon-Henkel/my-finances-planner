<?php

namespace App\Modules\SpendingPlan\Exceptions;

use App\Exceptions\ResponseExceptions\BadRequestException;

class YearQueryParamMissingException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct("Parâmetro 'year' é obrigatório");
    }
}
