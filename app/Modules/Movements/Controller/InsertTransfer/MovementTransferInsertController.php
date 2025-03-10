<?php

namespace App\Modules\Movements\Controller\InsertTransfer;

use App\Infra\Controller\Insert\BaseInsertController;
use App\Modules\Movements\UseCase\InsertTransfer\MovementTransferInsertUseCase;

class MovementTransferInsertController extends BaseInsertController
{
    public function __construct(protected MovementTransferInsertUseCase $useCase)
    {
    }

    protected function getUseCase(): MovementTransferInsertUseCase
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
