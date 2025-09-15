<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Read\BaseListControllerV2;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Modules\Wallet\UseCase\WalletListUseCase;

class WalletListController extends BaseListControllerV2
{
    public function __construct(private WalletListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCaseV2
    {
        return $this->useCase;
    }
}
