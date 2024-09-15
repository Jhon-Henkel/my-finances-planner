<?php

namespace App\DTO\Subscription;

class SubscriptionDTO
{
    private string $status;
    private string $subscriptionId;

    public function __construct(array $response)
    {
        $this->status = $response['status'];
        $this->subscriptionId = $response['id'];
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'subscriptionId' => $this->subscriptionId,
        ];
    }
}
