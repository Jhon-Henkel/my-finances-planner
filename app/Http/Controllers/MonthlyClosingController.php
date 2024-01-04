<?php

namespace App\Http\Controllers;

use App\Http\Response\ResponseError;
use App\Resources\Tools\MonthlyClosingResource;
use App\Services\Tools\MonthlyClosingService;
use App\Tools\Request\RequestTools;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MonthlyClosingController extends BasicController
{
    protected MonthlyClosingService $service;
    protected MonthlyClosingResource $resource;

    public function __construct(MonthlyClosingService $service)
    {
        $this->service = $service;
        $this->resource = app(MonthlyClosingResource::class);
    }

    protected function rulesInsert(): array
    {
        return [
            'predicted_earnings' => 'required|decimal:0,2',
            'predicted_expenses' => 'required|decimal:0,2',
            'real_earnings' => 'decimal:0,2',
            'real_expenses' => 'decimal:0,2',
            'balance' => 'decimal:0,2'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'predicted_earnings' => 'required|decimal:0,2',
            'predicted_expenses' => 'required|decimal:0,2',
            'real_earnings' => 'required|decimal:0,2',
            'real_expenses' => 'required|decimal:0,2',
            'balance' => 'required|decimal:0,2'
        ];
    }

    protected function getService(): MonthlyClosingService
    {
        return $this->service;
    }

    protected function getResource(): MonthlyClosingResource
    {
        return $this->resource;
    }

    public function indexFiltered(): JsonResponse
    {
        $filterOption = RequestTools::inputGet();
        $user = RequestTools::getUserDataInRequest();
        if (! $user) {
            return ResponseError::responseError('Usuário não encontrado', Response::HTTP_BAD_REQUEST);
        }
        $results = $this->getService()->findByFilter($filterOption, $user->data->tenant_id);
        $items['data'] = array_reverse($this->getResource()->arrayDtoToVoItens($results['data']));
        $items['chartData'] = $results['chartData'];
        return response()->json($items, Response::HTTP_OK);
    }
}