<?php

namespace App\Services\PaymentMethod;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Models\User;

interface IPaymentMethod
{
    public function createAgreement(User $user): SubscriptionAgreementDTO;
    public function getSubscription(User $user): SubscriptionDTO;
    public function cancelSubscription(string $subscriptionId, string $reason): void;
    public function getActiveSubscriptionStatus(): string;
}
