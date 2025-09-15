<?php

namespace App\Modules\Old\Movements\Controller\Delete;

use App\Infra\Controller\Delete\BaseDeleteController;
use App\Modules\Old\Movements\UseCase\Delete\MovementDeleteUseCase;

class MovementDeleteController extends BaseDeleteController
{
    public function __construct(protected MovementDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): MovementDeleteUseCase
    {
        return $this->useCase;
    }
}
