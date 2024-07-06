<?php

namespace App\Repositories\Log;

use App\Models\Log\AccessLogModel;
use App\Repositories\BasicRepository;
use App\Resources\Log\AccessLogResource;

class AccessLogRepository extends BasicRepository
{
    public function __construct(
        private readonly AccessLogModel $model,
        private readonly AccessLogResource $resource
    ) {
    }

    protected function getModel(): AccessLogModel
    {
        return $this->model;
    }

    protected function getResource(): AccessLogResource
    {
        return $this->resource;
    }
}
