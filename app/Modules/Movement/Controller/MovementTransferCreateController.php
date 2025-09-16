<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\Movement\UseCase\MovementTransferCreateUseCase;

class MovementTransferCreateController extends BaseCreateControllerV2
{
    public function __construct(private MovementTransferCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
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
