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

    public function createAgreement(): void
    {
        $user = Auth::user()->toArray();
//        $agreement = $this->paymentMethod->createAgreement($user);
//        $this->paymentMethod->cancelSubscription('I-GUTESYA1WHRX', 'Canceling the subscription');
        $subscription = $this->paymentMethod->getSubscription('I-GUTESYA1WHRX');
//        dd($agreement, $subscription);
        dd($subscription);
        // todo - salvar o id da assinatura no banco
    }

    public function cancelAgreement(string $reason): void
    {
        $user = Auth::user()->toArray();
        $this->paymentMethod->cancelSubscription('I-GUTESYA1WHRX', $reason);
        // todo - remover o id da assinatura do banco
    }
}
