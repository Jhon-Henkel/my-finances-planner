<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Delete\BaseDeleteController;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\Wallet\UseCase\WalletDeleteUseCase;

class WalletDeleteController extends BaseDeleteController
{
    public function __construct(private WalletDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
