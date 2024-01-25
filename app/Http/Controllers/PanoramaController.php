<?php

namespace App\Http\Controllers;

use App\Services\PanoramaService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PanoramaController
{
    protected PanoramaService $service;

    public function __construct(PanoramaService $service)
    {
        $this->service = $service;
    }

    public function getPanoramaData(): JsonResponse
    {
        $data = $this->service->getPanoramaData();
        return response()->json($data, ResponseAlias::HTTP_OK);
    }
}