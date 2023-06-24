<?php

namespace App\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Services\FinancialHealthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FinancialHealthController
{
    protected FinancialHealthService $service;

    public function __construct(FinancialHealthService $service)
    {
        $this->service = $service;
    }

    public function getService(): FinancialHealthService
    {
        return $this->service;
    }

    public function getResource()
    {
        throw new NotImplementedException();
    }

    public function indexFiltered(string|int $filterOption): JsonResponse
    {
        $data = $this->getService()->findByFilter((int)$filterOption);
        return response()->json($data, ResponseAlias::HTTP_OK);
    }
}