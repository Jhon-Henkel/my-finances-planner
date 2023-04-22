<?php

namespace App\Http\Controllers;

use App\Resources\MovementResource;
use App\Services\MovementService;
use App\VO\MovementVO;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

// todo alterações via api não estão afetandoo a carteira (adiciionar e remover saldo)
/**
 * @method MovementVO[] showByType()
 */
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
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
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

    protected function indexFiltered(string|int $filterOption): JsonResponse
    {
        $find = $this->getService()->findByFilter((int)$filterOption);
        $itens = $this->getResource()->arrayDtoToVoItens($find);
        return response()->json($itens, ResponseAlias::HTTP_OK);
    }
}