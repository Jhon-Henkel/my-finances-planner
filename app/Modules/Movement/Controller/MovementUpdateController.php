<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Update\BaseUpdateController;
use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Movement\UseCase\MovementUpdateUseCase;

class MovementUpdateController extends BaseUpdateController
{
    public function __construct(private MovementUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCase
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
