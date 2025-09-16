<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Movement\UseCase\MovementGetUseCase;

class MovementGetController extends BaseGetControllerV2
{
    public function __construct(private MovementGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
