<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Wallet\UseCase\WalletListUseCase;

class WalletListController extends BaseListController
{
    public function __construct(private WalletListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
