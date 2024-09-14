<?php

namespace App\Services\PaymentMethod\PayPal;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Enums\ConfigEnum;
use App\Enums\Response\StatusCodeEnum;
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

    protected function getToken(): string
    {
        if ($this->auth && !$this->auth->isExpired()) {
            return $this->auth->getAccessToken();
        }
        $client = $this->getClient('application/x-www-form-urlencoded');
        $response = $client->post('oauth2/token', ['form_params' => ['grant_type' => 'client_credentials']]);
        $this->auth = new PayPalAuthDTO(json_decode($response->getBody()->getContents(), true));
        return $this->auth->getAccessToken();
    }

    public function createAgreement(array $userData): SubscriptionAgreementDTO
    {
        $data = PayPalRequestDataFactory::makeAgreementBody($userData['name'], $userData['email']);
        $client = $this->getClient(authorization: $this->getToken());
        $response = $client->post('billing/subscriptions', ['body' => json_encode($data)]);
        if ($response->getStatusCode() !== StatusCodeEnum::HttpCreated->value) {
            // todo - tratar possíveis erros
            throw new \Exception('Erro ao criar assinatura'); // todo - fazer exception específico
        }
        // todo - tem que validar o status antes de devolver esse item
        return new SubscriptionAgreementDTO(json_decode($response->getBody()->getContents(), true));
    }

    public function getSubscription(string $subscriptionId): SubscriptionDTO
    {
        $client = $this->getClient(authorization: $this->getToken());
        $response = $client->get("billing/subscriptions/$subscriptionId");
        if ($response->getStatusCode() !== StatusCodeEnum::HttpOk->value) {
            throw new \Exception('Erro ao buscar assinatura'); // todo - fazer exception específico
        }
        return new SubscriptionDTO(json_decode($response->getBody()->getContents(), true));
    }

    public function cancelSubscription(string $subscriptionId, string $reason): void
    {
        $client = $this->getClient(authorization: $this->getToken());
        $data = ['reason' => $reason];
        $response = $client->post("billing/subscriptions/$subscriptionId/cancel", ['body' => json_encode($data)]);
        if ($response->getStatusCode() !== StatusCodeEnum::HttpNoContent->value) {
            throw new \Exception('Erro ao cancelar assinatura'); // todo - fazer exception específico
        }
    }
}
