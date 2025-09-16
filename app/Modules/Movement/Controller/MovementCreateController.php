<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementCreateUseCase;

class MovementCreateController extends BaseCreateControllerV2
{
    public function __construct(private MovementCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
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
