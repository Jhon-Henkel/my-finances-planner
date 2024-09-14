<?php

namespace App\Services\PaymentMethod\PayPal;

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

    public function paySubscribe(string $payerEmail, string $cardTokenId)
    {
        $this->getToken();
        dd($this->auth);
    }
}
