<?php

namespace App\Services\PaymentMethod;

interface IPaymentMethod
{
    // todo - tem que validar se a assinatura do método vai ficar assim
    public function paySubscribe(string $payerEmail, string $cardTokenId);
}
