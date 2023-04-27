<?php

namespace App\Http\Controllers;

use App\Resources\ConfigurationResource;
use App\Services\ConfigurationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ConfigurationsController extends BasicController
{
    protected ConfigurationService $service;
    protected ConfigurationResource $resource;

    public function __construct(ConfigurationService $service)
    {
        $this->service = $service;
        $this->resource = app(ConfigurationResource::class);
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

    /**
     * @throws Exception
     */
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