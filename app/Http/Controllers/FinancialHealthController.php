<?php

namespace App\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Services\Tools\FinancialHealthService;
use App\Tools\Request\RequestTools;
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

    public function indexFiltered(): JsonResponse
    {
        $filterOption = RequestTools::inputGet();
        $data = $this->getService()->findByFilter($filterOption);
        return response()->json($data, ResponseAlias::HTTP_OK);
    }
}