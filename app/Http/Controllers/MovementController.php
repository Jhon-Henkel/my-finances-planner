<?php

namespace App\Http\Controllers;

use App\Resources\MovementResource;
use App\Services\MovementService;
use App\VO\MovementVO;

class MovementController extends BasicController
{
    protected MovementService $service;
    protected MovementResource $resource;

    public function __construct(MovementService $service)
    {
        $this->service = $service;
        $this->resource = app(MovementResource::class);
    }

    protected function rulesInsert(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            'walletId' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            'walletId' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function getService(): MovementService
    {
        return $this->service;
    }

    protected function getResource(): MovementResource
    {
        return $this->resource;
    }

    /**
     * @param int $type
     * @return MovementVO[]
     */
    public function showByType(int $type): array
    {
        $itens = $this->service->findAllByType($type);
        return $this->resource->arrayDtoToVoItens($itens);
    }
}