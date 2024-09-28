<?php

namespace App\DTO\Subscription;

use App\Enums\PaymentMethod\PaymentMethodNameEnum;
use App\Exceptions\PaymentMethod\PaymentMethodApproveLinkSubscriptionException;

class SubscriptionAgreementDTO
{
    private string $status;
    private string $subscriptionId;
    private string $createTime;
    private string $approveLink;
    private string $paymentMethod;

    public function __construct(array $response)
    {
        $this->subscriptionId = $response['id'];
        $this->paymentMethod = config('app.payment_method_name');
        $this->populateData($response);
        $this->populateLinkData($response);
    }

    protected function populateData(array $response): void
    {
        if ($this->paymentMethod == PaymentMethodNameEnum::Stripe->value) {
            $this->status = $response['status'] ?? '';
            $this->createTime = '';
        }
    }

    protected function populateLinkData(array $response): void
    {
        if ($this->paymentMethod == PaymentMethodNameEnum::Stripe->value) {
            $this->approveLink = $response['url'];
            return;
        }
        throw new PaymentMethodApproveLinkSubscriptionException($this->subscriptionId);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function getApproveLink(): string
    {
        return $this->approveLink;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'subscriptionId' => $this->subscriptionId,
            'createTime' => $this->createTime,
            'approveLink' => $this->approveLink
        ];
    }
}
