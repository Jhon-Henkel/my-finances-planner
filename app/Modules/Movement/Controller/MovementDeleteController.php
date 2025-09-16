<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\Movement\UseCase\MovementDeleteUseCase;

class MovementDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private MovementDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
