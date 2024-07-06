<?php

namespace App\Repositories;

use App\Models\Configurations;
use App\Resources\ConfigurationResource;

class ConfigurationRepository extends BasicRepository
{
    public function __construct(
        private readonly Configurations $model,
        private readonly ConfigurationResource $resource
    ) {
    }

    protected function getModel(): Configurations
    {
        return $this->model;
    }

    protected function getResource(): ConfigurationResource
    {
        return $this->resource;
    }
}
