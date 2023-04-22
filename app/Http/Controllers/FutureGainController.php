<?php

namespace App\Http\Controllers;

use App\Resources\FutureGainResource;
use App\Services\FutureGainService;

class FutureGainController extends BasicController
{
    protected FutureGainService $service;
    protected FutureGainResource $resource;

    public function __construct(FutureGainService $service)
    {
        $this->service = $service;
        $this->resource = app(FutureGainResource::class);
    }

    protected function rulesInsert(): array
    {
        // TODO: Implement rulesInsert() method.
    }

    protected function rulesUpdate(): array
    {
        // TODO: Implement rulesUpdate() method.
    }

    protected function getService(): FutureGainService
    {
        return $this->service;
    }

    protected function getResource(): mixed
    {
        return $this->resource;
    }
}