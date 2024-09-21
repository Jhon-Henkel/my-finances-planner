<?php

namespace App\Http\Controllers;

use App\Enums\Gates\GatesAbilityEnum;
use App\Exceptions\NotImplementedException;
use App\Exceptions\Plan\LimitExceededException;
use App\Services\Tools\FinancialHealthService;
use App\Tools\Request\RequestTools;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FinancialHealthController
{
    public function __construct(private readonly FinancialHealthService $service)
    {
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
        LimitExceededException::validateExceeded(GatesAbilityEnum::List, 'financial-health');
        $filterOption = RequestTools::inputGet();
        $data = $this->getService()->findByFilter($filterOption);
        return response()->json($data, ResponseAlias::HTTP_OK);
    }
}
