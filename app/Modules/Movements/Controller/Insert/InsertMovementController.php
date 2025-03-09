<?php

namespace App\Modules\Movements\Controller\Insert;

use App\Infra\Controller\Insert\BaseInsertController;
use App\Modules\Movements\UseCase\Insert\MovementInsertUseCase;

class InsertMovementController extends BaseInsertController
{
    public function __construct(protected MovementInsertUseCase $useCase)
    {
    }

    protected function getUseCase(): MovementInsertUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'amount' => 'required|decimal:0,2'
        ];
    }
}
