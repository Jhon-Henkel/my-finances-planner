<?php

namespace App\DTO\Subscription;

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
        // todo - throw exception
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function getCreateTime(): string
    {
        return $this->createTime;
    }

    public function getApproveLink(): string
    {
        return $this->approveLink;
    }
}
