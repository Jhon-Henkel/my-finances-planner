<?php

namespace App\Services\PaymentMethod\PayPal;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\Enums\ConfigEnum;
use App\Services\PaymentMethod\IPaymentMethod;
use GuzzleHttp\Client;

class PayPalService implements IPaymentMethod
{
    private null|PayPalAuthDTO $auth = null;

    protected function getClient(string $contentType = 'application/json', string $authorization = null): Client
    {
        return new Client([
            'base_uri' => $this->makeRequestBaseUrl(),
            'headers' => [
                'Content-Type' => $contentType,
                'Authorization' => $authorization ? "Bearer $authorization" : $this->makeBasicAuthToken()
            ],
            'http_errors' => false
        ]);
    }

    protected function makeRequestBaseUrl(): string
    {
        if (config('app.env') === ConfigEnum::DevDotEnv->value) {
            return "https://api-m.sandbox.paypal.com/v1/";
        }
        return 'https://api-m.paypal.com/v1/';
    }

    protected function makeBasicAuthToken(): string
    {
        $client_id = config('app.payment_method_client_id');
        $client_secret = config('app.payment_method_client_secret');
        return 'Basic ' . base64_encode("$client_id:$client_secret");
    }

    public function getToken(): PayPalAuthDTO
    {
        if ($this->auth && ! $this->auth->isExpired()) {
            return $this->auth;
        }
        $client = $this->getClient('application/x-www-form-urlencoded');
        $response = $client->post('oauth2/token', ['form_params' => ['grant_type' => 'client_credentials']]);
        $this->auth = new PayPalAuthDTO(json_decode($response->getBody()->getContents(), true));
        return $this->auth;
    }

    public function createAgreement(): SubscriptionAgreementDTO
    {
        $data = [
            "plan_id" => 'PLAN_ID',
            "quantity" => '1',
            "custom_id" => 'CUST-1234',
            "subscriber" => [
                "name" => [
                    "given_name" => 'USER NAME',
                    "surname" => 'USER SURNAME',
                ],
                "email_address" => 'USER_EMAIL',
            ],
            "application_context" => [
                "brand_name" => "Finanças na Mão",
                "locale" => "pt-BR",
                "shipping_preference" => "NO_SHIPPING",
                "user_action" => "SUBSCRIBE_NOW",
                "payment_method" => [
                    "payer_selected" => "PAYPAL",
                    "payee_preferred" => "IMMEDIATE_PAYMENT_REQUIRED",
                ],
                "return_url" => "https://financasnamao.com.br/execute_subscription.php?success=true",
                "cancel_url" => "https://financasnamao.com.br/execute_subscription.php?success=false",
            ]
        ];
        $client = $this->getClient(authorization: $this->getToken()->getAccessToken());
        $response = $client->post('billing/subscriptions', ['body' => json_encode($data)]);
        $dataDecoded = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() !== 201) {
            throw new \Exception('Erro ao criar assinatura'); // todo - fazer exception específico
        }
        return new SubscriptionAgreementDTO($dataDecoded);
    }

    /**
     * Criar os métodos:
     * - validar assinatura: https://developer.paypal.com/docs/api/subscriptions/v1/#subscriptions_get
     * - cancelar assinatura: https://developer.paypal.com/docs/api/subscriptions/v1/#subscriptions_cancel
     *
     */
}
