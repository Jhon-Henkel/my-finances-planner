<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DashboardController
{
    public function __construct(protected DashboardService $service)
    {
    }

    public function index(): JsonResponse
    {
        $data = $this->service->getDashboardData();
        return response()->json($data, ResponseAlias::HTTP_OK);
    }
}