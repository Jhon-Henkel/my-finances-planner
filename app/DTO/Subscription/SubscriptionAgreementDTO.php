<?php

namespace App\DTO\Subscription;

use App\Exceptions\PaymentMethod\PaymentMethodApproveLinkSubscriptionException;

class SubscriptionAgreementDTO
{
    private string $status;
    private string $subscriptionId;
    private string $createTime;
    private string $approveLink;

    private const string LINK_TO_PAY = 'approve';

    public function __construct(array $response)
    {
        $this->status = $response['status'];
        $this->subscriptionId = $response['id'];
        $this->createTime = $response['create_time'];
        $this->approveLink = $this->searchApproveLink($response['links']);
    }

    protected function searchApproveLink(array $links): string
    {
        foreach ($links as $link) {
            if ($link['rel'] === self::LINK_TO_PAY) {
                return $link['href'];
            }
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
