<?php

namespace App\Repositories;

use App\Models\Configurations;
use App\Resources\ConfigurationResource;

class ConfigurationRepository extends BasicRepository
{
    protected Configurations $model;
    protected ConfigurationResource $resource;

    public function __construct(Configurations $model)
    {
        $this->model = $model;
        $this->resource = app(ConfigurationResource::class);
    }

    protected function getModel(): Configurations
    {
        return $this->model;
    }

    protected function getResource()
    {
        return $this->resource;
    }
}