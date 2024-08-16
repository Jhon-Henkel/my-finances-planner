<?php

namespace App\DTO\Queue;

use App\Enums\DateFormatEnum;
use App\Enums\Queue\QueueNameEnum;
use App\Enums\Request\RequestTypeEnum;
use App\Enums\Response\StatusCodeEnum;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Support\Facades\Crypt;

class QueueDataDTO
{
    private string $queueAdditionDate;

    public function __construct(
        private readonly string $url,
        private readonly RequestTypeEnum $method,
        private readonly StatusCodeEnum $expectedResponseCode,
        protected readonly QueueNameEnum $queueName,
        private readonly array $data = [],
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
        $appUrl = str_replace('https://', 'http://', config('app.url'));
        $data = [
            'url' => str_replace(config('app.url'), config('app.url_container_app'), $this->url),
            'method' => $this->method->value,
            'data' => Crypt::encryptString(json_encode($this->data)),
            'expected_response_code' => $this->expectedResponseCode->value,
            'queue_addition_date' => $this->queueAdditionDate,
        ];
        return json_encode($data);
    }
}
