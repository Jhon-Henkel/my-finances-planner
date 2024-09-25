<?php

namespace App\Enums\PaymentMethod;

enum PaymentMethodNameEnum: string
{
    case PayPal = 'paypal';
    case Stripe = 'stripe';
}
