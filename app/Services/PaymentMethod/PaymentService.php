<?php

namespace App\Services\PaymentMethod;

use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\PaymentMethod\PaymentMethodNotFountException;
use App\Services\PaymentMethod\PayPal\PayPalService;

class PaymentService
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
        $data = $this->paymentMethod->createAgreement();
    }
}
