<?php

namespace App\Repositories;

use App\Models\ConfigModel;
use App\Resources\ConfigResource;

class ConfigRepository extends BasicRepository
{
    protected ConfigModel $model;
    protected ConfigResource $resource;

    public function __construct(ConfigModel $model)
    {
        $this->model = $model;
        $this->resource = app(ConfigResource::class);
    }

    protected function getModel(): ConfigModel
    {
        return $this->model;
    }

    protected function getResource()
    {
        return $this->resource;
    }
}
