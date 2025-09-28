<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Read\BaseGetController;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\Movement\UseCase\MovementGetUseCase;

class MovementGetController extends BaseGetController
{
    public function __construct(private MovementGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
