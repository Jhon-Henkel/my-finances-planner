<?php

namespace App\DTO\Subscription;

class SubscriptionDTO
{
    // PayPal subscription statuses
    private const string PENDING = 'APPROVAL_PENDING';
    private const string APPROVED = 'APPROVED';
    private const string ACTIVE = 'ACTIVE';
    private const string SUSPENDED = 'SUSPENDED';
    private const string CANCELLED = 'CANCELLED';
    private const string EXPIRED = 'EXPIRED';

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

    public function isActive(): bool
    {
        return $this->status === self::ACTIVE;
    }
}
