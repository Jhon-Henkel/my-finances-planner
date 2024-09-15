<?php

namespace App\Exceptions\PaymentMethod;

use App\Exceptions\ResponseExceptions\BadRequestException;

class PaymentMethodGetSubscriptionException extends BadRequestException
{
    public function __construct(string $subscriptionId)
    {
        parent::__construct("Ocorreu um erro ao buscar a assinatura $subscriptionId");
    }
}
