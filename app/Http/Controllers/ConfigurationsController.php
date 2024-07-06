<?php

namespace App\Http\Controllers;

use App\Resources\ConfigurationResource;
use App\Services\ConfigurationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ConfigurationsController extends BasicController
{
    public function __construct(
        private readonly ConfigurationService $service,
        private readonly ConfigurationResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [];
    }

    protected function rulesUpdate(): array
    {
        return [
            'value' => 'required',
        ];
    }

    protected function getService(): ConfigurationService
    {
        return $this->service;
    }

    protected function getResource(): ConfigurationResource
    {
        return $this->resource;
    }

    public function showByName(string $name): JsonResponse
    {
        $config = strtolower($name);
        $item = $this->service->findConfigByName($config);
        return response()->json($this->resource->dtoToVo($item), ResponseAlias::HTTP_OK);
    }

    public function updateByName(string $name): JsonResponse
    {
        $config = strtolower($name);
        $item = $this->service->findConfigByName($config);
        $item->setValue(request()->input('value'));
        $item = $this->service->update($item->getId(), $item);
        return response()->json($this->resource->dtoToVo($item), ResponseAlias::HTTP_OK);
    }
}
