<?php

namespace App\Modules\Movements\Controller\Delete;

use App\Infra\Controller\Delete\BaseDeleteController;
use App\Modules\Movements\UseCase\Delete\MovementDeleteUseCase;

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
