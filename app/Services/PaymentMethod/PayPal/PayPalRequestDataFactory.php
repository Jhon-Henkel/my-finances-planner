<?php

namespace App\Services\PaymentMethod\PayPal;

class PayPalRequestDataFactory
{
    private const string SHIPPING_PREFERENCE = 'NO_SHIPPING';
    private const string USER_ACTION = 'SUBSCRIBE_NOW';
    private const string PAYPAL = 'PAYPAL';
    private const string PAYEE_PREFERRED = 'IMMEDIATE_PAYMENT_REQUIRED';
    private const string LOCALE = 'pt-BR';
    private const string RETURN_URI = '/v2/assinatura-sucesso';
    private const string CANCEL_URI = '/v2/assinatura-cancelada';

    public static function makeAgreementBody(string $userName, string $email): array
    {
        return [
            "plan_id" => config('app.payment_method_plan_id'),
            "quantity" => '1',
            "subscriber" => [
                "name" => [
                    "given_name" => $userName,
                    "surname" => '',
                ],
                "email_address" => $email,
            ],
            "application_context" => [
                "brand_name" => "Finanças na Mão",
                "locale" => self::LOCALE,
                "shipping_preference" => self::SHIPPING_PREFERENCE,
                "user_action" => self::USER_ACTION,
                "payment_method" => [
                    "payer_selected" => self::PAYPAL,
                    "payee_preferred" => self::PAYEE_PREFERRED,
                ],
                "return_url" => config('app.url') . self::RETURN_URI . "?email=$email",
                "cancel_url" => config('app.url') . self::CANCEL_URI . "?email=$email",
            ]
        ];
    }
}
