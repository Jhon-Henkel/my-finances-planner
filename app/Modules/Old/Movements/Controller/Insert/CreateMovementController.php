<?php

namespace App\Modules\Old\Movements\Controller\Insert;

use App\Infra\Controller\Create\BaseCreateController;
use App\Modules\Old\Movements\UseCase\Insert\MovementCreateUseCase;

class CreateMovementController extends BaseCreateController
{
    public function __construct(protected MovementCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): MovementCreateUseCase
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
