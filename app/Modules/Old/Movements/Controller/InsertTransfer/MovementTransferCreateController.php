<?php

namespace App\Modules\Old\Movements\Controller\InsertTransfer;

use App\Infra\Controller\Create\BaseCreateController;
use App\Modules\Old\Movements\UseCase\InsertTransfer\MovementTransferCreateUseCase;

class MovementTransferCreateController extends BaseCreateController
{
    public function __construct(protected MovementTransferCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): MovementTransferCreateUseCase
    {
        return  $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'originId' => 'required|int|exists:App\Models\WalletModel,id',
            'destinationId' => 'required|int|exists:App\Models\WalletModel,id',
            'amount' => 'required|decimal:0,2'
        ];
    }
}
