<?php

namespace App\Exceptions\PaymentMethod;

use App\Exceptions\ResponseExceptions\BadRequestException;

class PaymentMethodApproveLinkSubscriptionException extends BadRequestException
{
    public function __construct(string $subscriptionId)
    {
        parent::__construct("Ocorreu um erro ao buscar o link de aprovação da assinatura $subscriptionId");
    }
}
