<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Create\BaseCreateController;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementCreateUseCase;

class MovementCreateController extends BaseCreateController
{
    public function __construct(private MovementCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCase
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'walletId' => 'required|integer|exists:wallets,id',
            'description' => 'required|string',
            'type' => 'required|in:' . MovementTypeEnum::getForValidation(),
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
