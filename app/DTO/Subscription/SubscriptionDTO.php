<?php

namespace App\DTO\Subscription;

use DateTime;

class SubscriptionDTO
{
    private string $status;
    private string $currentPeriodEndTimestamp;

    public function __construct(array $response)
    {
        $this->status = $response['status'];
        $this->currentPeriodEndTimestamp = $response['current_period_end'];
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCurrentPeriodEnd(): DateTime
    {
        return new DateTime('@' . $this->currentPeriodEndTimestamp);
    }
}
