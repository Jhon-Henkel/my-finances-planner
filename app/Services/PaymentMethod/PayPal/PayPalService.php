<?php

namespace App\Services\PaymentMethod\PayPal;

use App\DTO\Subscription\SubscriptionAgreementDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Enums\ConfigEnum;
use App\Enums\Response\StatusCodeEnum;
use App\Exceptions\PaymentMethod\PaymentMethodCancelSubscriptionException;
use App\Exceptions\PaymentMethod\PaymentMethodCreateSubscriptionException;
use App\Exceptions\PaymentMethod\PaymentMethodGetSubscriptionException;
use App\Services\PaymentMethod\IPaymentMethod;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class PayPalService implements IPaymentMethod
{
    private null|PayPalAuthDTO $auth = null;

    protected function getClient(string $authorization = null, string $contentType = 'application/json'): Client
    {
        return new Client([
            'base_uri' => $this->makeRequestBaseUrl(),
            'headers' => [
                'Content-Type' => $contentType,
                'Authorization' => $authorization ?? "Bearer {$this->getToken()}"
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
        $client = $this->getClient($this->makeBasicAuthToken(), 'application/x-www-form-urlencoded');
        $response = $client->post('oauth2/token', ['form_params' => ['grant_type' => 'client_credentials']]);
        $this->auth = new PayPalAuthDTO(json_decode($response->getBody()->getContents(), true));
        return $this->auth->getAccessToken();
    }

    protected function post(string $uri, array $data): ResponseInterface
    {
        return $this->getClient()->post($uri, ['body' => json_encode($data)]);
    }

    public function createAgreement(array $userData): SubscriptionAgreementDTO
    {
        $data = PayPalRequestDataFactory::makeAgreementBody($userData['name'], $userData['email']);
        $response = $this->post('billing/subscriptions', $data);
        if ($response->getStatusCode() !== StatusCodeEnum::HttpCreated->value) {
            // todo - tratar possíveis erros
            throw new PaymentMethodCreateSubscriptionException($userData['email']);
        }
        // todo - tem que validar o status code antes de devolver esse item
        return new SubscriptionAgreementDTO(json_decode($response->getBody()->getContents(), true));
    }

    public function getSubscription(string $subscriptionId): SubscriptionDTO
    {
        $response = $this->getClient()->get("billing/subscriptions/$subscriptionId");
        if ($response->getStatusCode() !== StatusCodeEnum::HttpOk->value) {
            throw new PaymentMethodGetSubscriptionException($subscriptionId);
        }
        return new SubscriptionDTO(json_decode($response->getBody()->getContents(), true));
    }

    public function cancelSubscription(string $subscriptionId, string $reason): void
    {
        $response = $this->post("billing/subscriptions/$subscriptionId/cancel", ['reason' => $reason]);
        if ($response->getStatusCode() !== StatusCodeEnum::HttpNoContent->value) {
            throw new PaymentMethodCancelSubscriptionException($subscriptionId);
        }
    }
}
