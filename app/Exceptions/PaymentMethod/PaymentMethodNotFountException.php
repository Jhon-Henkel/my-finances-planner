<?php

namespace App\Exceptions\PaymentMethod;

use App\Exceptions\ResponseExceptions\BadRequestException;

class PaymentMethodNotFountException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct("Forma de pagamento configurada não encontrada!");
    }
}
