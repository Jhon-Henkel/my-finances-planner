<?php

namespace App\Http\Controllers;

use App\Resources\ConfigurationResource;
use App\Services\ConfigurationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            '*.name' => 'required|string',
            '*.value' => 'required|string'
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

    public function updateConfigs(Request $request): JsonResponse
    {
        $data = $request->json()->all();
        $this->validate($request, $this->rulesUpdate());
        $this->getService()->updateConfigs($data);
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
