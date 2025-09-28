<?php

namespace App\Modules\Movement\Controller\Transfer;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Movement\UseCase\Transfer\MovementTransferCreateUseCase;

class MovementTransferCreateController extends BaseCreateController
{
    public function __construct(private MovementTransferCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'originWalletId' => 'required|integer|different:destinationWalletId|exists:wallets,id',
            'destinationWalletId' => 'required|integer|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
