<?php

namespace App\DTO\Subscription;

class SubscriptionAgreementDTO
{
    private string $status;
    private string $id;
    private string $createTime;
    private string $approveLink;

    public function __construct(array $response)
    {
        $this->status = $response['status'];
        $this->id = $response['id'];
        $this->createTime = $response['create_time'];
        $this->approveLink = $this->searchApproveLink($response['links']);
    }

    protected function searchApproveLink(array $links): string
    {
        foreach ($links as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }
        // todo - throw exception
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCreateTime(): string
    {
        return $this->createTime;
    }

    public function setCreateTime(string $createTime): void
    {
        $this->createTime = $createTime;
    }

    public function getApproveLink(): string
    {
        return $this->approveLink;
    }

    public function setApproveLink(string $approveLink): void
    {
        $this->approveLink = $approveLink;
    }
}
