<?php

namespace App\Repositories\Log;

use App\Models\Log\AccessLogModel;
use App\Repositories\BasicRepository;
use App\Resources\Log\AccessLogResource;

class AccessLogRepository extends BasicRepository
{
    protected AccessLogModel $model;
    protected AccessLogResource $resource;

    public function __construct(AccessLogModel $model)
    {
        $this->model = $model;
        $this->resource = app(AccessLogResource::class);
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