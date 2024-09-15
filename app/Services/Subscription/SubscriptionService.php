<?php

namespace App\Services\Subscription;

use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\PaymentMethod\PaymentMethodNotFountException;
use App\Services\PaymentMethod\IPaymentMethod;
use App\Services\PaymentMethod\PayPal\PayPalService;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    private IPaymentMethod $paymentMethod;

    public function __construct()
    {
        $this->paymentMethod = $this->getPaymentMethodInstance();
    }

    protected function getPaymentMethodInstance(): IPaymentMethod
    {
        return match (config('app.payment_method_name')) {
            PaymentMethodNameEnum::PayPal->value => new PayPalService(),
            default => throw new PaymentMethodNotFountException(),
        };
    }

    public function createAgreement(): array
    {
        $user = Auth::user();
        $agreement = $this->paymentMethod->createAgreement($user);
        $user->subscriptionId = $agreement->getSubscriptionId();
        $user->save();
        return $agreement->toArray();
    }

    public function cancelAgreement(string $reason): void
    {
        $user = Auth::user();
        $this->paymentMethod->cancelSubscription($user->subscriptionId, $reason);
        $user->subscriptionId = null;
        $user->save();
    }

    public function getSubscription(): array
    {
        $user = Auth::user();
        $subscription = $this->paymentMethod->getSubscription($user->subscriptionId);
        return $subscription->toArray();
    }
}
