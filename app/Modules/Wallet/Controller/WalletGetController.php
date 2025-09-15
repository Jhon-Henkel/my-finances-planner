<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Wallet\UseCase\WalletGetUseCase;

class WalletGetController extends BaseGetControllerV2
{
    public function __construct(private WalletGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
