<?php

namespace App\Http\Controllers;

use App\Services\PanoramaService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PanoramaController extends Controller
{
    public function __construct(private readonly PanoramaService $service)
    {
    }

    public function getPanoramaData(): JsonResponse
    {
        $data = $this->service->getPanoramaData();
        return response()->json($data, ResponseAlias::HTTP_OK);
    }
}