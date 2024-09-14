<?php

namespace App\Services\PaymentMethod;

use App\DTO\Subscription\SubscriptionAgreementDTO;

interface IPaymentMethod
{
    public function createAgreement(): SubscriptionAgreementDTO;
}
