<?php

namespace App\Repositories\Log;

use App\Models\Log\AccessLog;
use App\Repositories\BasicRepository;
use App\Resources\Log\AccessLogResource;

class AccessLogRepository extends BasicRepository
{
    public function __construct(
        private readonly AccessLog $model,
        private readonly AccessLogResource $resource
    ) {
    }

    protected function getModel(): AccessLog
    {
        return $this->model;
    }

    protected function getResource(): AccessLogResource
    {
        return $this->resource;
    }
}
