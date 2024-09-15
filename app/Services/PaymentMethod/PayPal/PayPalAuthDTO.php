<?php

namespace App\Services\PaymentMethod\PayPal;

class PayPalAuthDTO
{
    private string $scope;
    private string $accessToken;
    private string $tokenType;
    private string $appId;
    private string $expiresIn;
    private string $nonce;

    public function __construct(array $data)
    {
        $this->scope = $data['scope'];
        $this->accessToken = $data['access_token'];
        $this->tokenType = $data['token_type'];
        $this->appId = $data['app_id'];
        $this->expiresIn = $data['expires_in'];
        $this->nonce = $data['nonce'];
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getExpiresIn(): string
    {
        return $this->expiresIn;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function isExpired(): bool
    {
        return $this->getExpiresIn() < time();
    }
}
