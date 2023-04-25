<?php

namespace App\Http\Controllers;

use App\Resources\WalletResource;
use App\Services\WalletService;
use App\VO\WalletVO;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @method WalletVO[] showByType()
 */
class WalletController extends BasicController
{
    protected WalletService $service;
    protected WalletResource $resource;

    public function __construct(WalletService $service)
    {
        $this->service = $service;
        $this->resource = app(WalletResource::class);
    }

    protected function rulesInsert(): array
    {
        return array(
            'name' => 'required|unique:App\Models\WalletModel,name|max:255|min:2|string',
            'type' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            // todo validar se nome já não existe em outro registro
            'name' => 'required|max:255|min:2|string',
            'type' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function getService(): WalletService
    {
        return $this->service;
    }

    protected function getResource(): WalletResource
    {
        return $this->resource;
    }

    public function getTotalWalletValue(): JsonResponse
    {
        $total = $this->getService()->getTotalWalletValue();
        return response()->json($total, ResponseAlias::HTTP_OK);
    }
}