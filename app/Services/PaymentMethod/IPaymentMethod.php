<?php

namespace App\Services\PaymentMethod;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;

interface IPaymentMethod
{
    public function createAgreement(array $userData): SubscriptionAgreementDTO;
    public function getSubscription(string $subscriptionId): SubscriptionDTO;
    public function cancelSubscription(string $subscriptionId, string $reason): void;
}
