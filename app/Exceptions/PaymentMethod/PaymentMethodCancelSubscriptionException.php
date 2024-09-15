<?php

namespace App\Exceptions\PaymentMethod;

use App\Exceptions\ResponseExceptions\BadRequestException;

class PaymentMethodCancelSubscriptionException extends BadRequestException
{
    public function __construct(string $subscriptionId)
    {
        parent::__construct("Ocorreu um erro ao cancelar a assinatura $subscriptionId");
    }
}
