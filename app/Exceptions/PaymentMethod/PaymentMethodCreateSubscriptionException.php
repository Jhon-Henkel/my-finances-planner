<?php

namespace App\Exceptions\PaymentMethod;

use App\Exceptions\ResponseExceptions\BadRequestException;

class PaymentMethodCreateSubscriptionException extends BadRequestException
{
    public function __construct(string $email)
    {
        parent::__construct("Ocorreu um erro ao criar assinatura para o usuário $email");
    }
}
