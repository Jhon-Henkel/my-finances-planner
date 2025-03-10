<?php

namespace App\Modules\Movements\Controller\Update;

use App\Infra\Controller\Update\BaseUpdateController;
use App\Modules\Movements\UseCase\Update\MovementUpdateUseCase;

class MovementUpdateController extends BaseUpdateController
{
    public function __construct(protected MovementUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): MovementUpdateUseCase
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
