<?php

namespace App\Services\Log;

use App\DTO\Log\AccessLogDTO;
use App\Repositories\Log\AccessLogRepository;
use App\Services\BasicService;

class AccessLogService extends BasicService
{
    public function __construct(
        private readonly AccessLogRepository $repository
    ) {
    }

    protected function getRepository(): AccessLogRepository
    {
        return $this->repository;
    }

    public function saveAccessLog(AccessLogDTO $logData): void
    {
        $this->repository->insert($logData);
    }
}
