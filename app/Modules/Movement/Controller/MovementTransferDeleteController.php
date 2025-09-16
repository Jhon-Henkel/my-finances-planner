<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\Movement\UseCase\MovementTransferDeleteUseCase;

class MovementTransferDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private MovementTransferDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
