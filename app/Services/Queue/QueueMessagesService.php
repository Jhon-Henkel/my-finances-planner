<?php

namespace App\Services\Queue;

use App\DTO\Queue\QueueDataDTO;
use App\Enums\Queue\QueueNameEnum;
use App\Enums\Request\RequestTypeEnum;
use App\Enums\Response\StatusCodeEnum;
use App\Enums\RouteEnum;

readonly class QueueMessagesService
{
    public function __construct(private QueueProducerService $queueProducerService)
    {
    }

    public function putMessageUserRegisterStepOne(array $data): void
    {
        $message = new QueueDataDTO(
            route(RouteEnum::MfpUserRegisterStepOne->value),
            RequestTypeEnum::Post,
            StatusCodeEnum::HttpCreated,
            QueueNameEnum::CreateUser,
            $data
        );
        $this->queueProducerService->produce($message);
    }
}
