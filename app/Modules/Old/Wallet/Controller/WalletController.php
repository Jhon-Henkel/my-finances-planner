<?php

namespace App\Modules\Old\Wallet\Controller;

use App\Http\Controllers\BasicController;
use App\Modules\Old\Wallet\Resource\WalletResource;
use App\Modules\Old\Wallet\Service\WalletService;
use App\Modules\Old\Wallet\VO\WalletVO;

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
            'amount' => 'required|decimal:0,2',
            'hide_value' => 'boolean',
            'active' => 'required|boolean'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'name' => 'required|max:255|min:2|string',
            'amount' => 'required|decimal:0,2',
            'hide_value' => 'boolean',
            'active' => 'required|boolean'
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
