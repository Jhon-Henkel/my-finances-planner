<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletResource;
use App\Services\WalletService;
use App\VO\WalletVO;

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

    /**
     * @param int $type
     * @return WalletVO[]
     */
    public function showByType(int $type): array
    {
        $itens = $this->service->findAllByType($type);
        return $this->resource->arrayDtoToVoItens($itens);
    }
}
