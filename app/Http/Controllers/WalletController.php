<?php

namespace App\Http\Controllers;

use App\Resources\WalletResource;
use App\Services\WalletService;
use App\VO\WalletVO;

/**
 * @method WalletVO[] showByType()
 */
class WalletController extends BasicController
{
    public function __construct(
        private readonly WalletService $service,
        private readonly WalletResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return array(
            'name' => 'required|max:255|min:2|string',
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
}
