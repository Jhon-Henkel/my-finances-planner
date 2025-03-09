<?php

namespace App\Http\Controllers;

use App\Resources\Movement\MovementResource;
use App\Services\Movement\MovementService;
use App\Tools\Request\RequestTools;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MovementController extends BasicController
{
    public function __construct(
        private readonly MovementService $service,
        private readonly MovementResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return [];
    }

    protected function rulesUpdate(): array
    {
        return [];
    }

    protected function getService(): MovementService
    {
        return $this->service;
    }

    protected function getResource(): MovementResource
    {
        return $this->resource;
    }

    public function indexFiltered(): JsonResponse
    {
        $params = RequestTools::inputGet();
        $find = $this->getService()->findByFilter($params);
        $itens = $this->getResource()->arrayDtoToVoItens($find);
        return response()->json($itens, ResponseAlias::HTTP_OK);
    }

    public function deleteTransfer(int $id): JsonResponse
    {
        $this->getService()->deleteTransferById($id);
        return response()->json(null, ResponseAlias::HTTP_OK);
    }
}
