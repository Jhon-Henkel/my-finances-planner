<?php

namespace App\DTO\Queue;

use App\Enums\DateFormatEnum;
use App\Enums\Queue\QueueNameEnum;
use App\Tools\Calendar\CalendarTools;

class QueueDataDTO
{
    private string $queueAdditionDate;

    public function __construct(
        private readonly string $url,
        private readonly string $method,
        private readonly array $data,
        private readonly int $expectedResponseCode,
        protected readonly QueueNameEnum $queueName
    ) {
    }

    public function addAdditionDate(): void
    {
        $this->queueAdditionDate = CalendarTools::getDateNow()->format(DateFormatEnum::DefaultDbDateFormat->value);
    }

    public function getQueueName(): string
    {
        return $this->queueName->value;
    }

    public function toJson(): string
    {
        $data = [
            'url' => $this->url,
            'method' => $this->method,
            'data' => $this->data,
            'expected_response_code' => $this->expectedResponseCode,
            'queue_addition_date' => $this->queueAdditionDate,
        ];
        return json_encode($data);
    }
}
