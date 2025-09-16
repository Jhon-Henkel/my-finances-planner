<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Update\BaseUpdateControllerV2;
use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementUpdateUseCase;

class MovementUpdateController extends BaseUpdateControllerV2
{
    public function __construct(private MovementUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'description' => 'required|string',
            'type' => 'required|in:' . MovementTypeEnum::getForValidation(),
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
