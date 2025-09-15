<?php

namespace App\Modules\Old\Movements\Controller\DeleteTransfer;

use App\Infra\Controller\Delete\BaseDeleteController;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\Old\Movements\UseCase\DeleteTransfer\MovementTransferDeleteUseCase;

class MovementTransferDeleteController extends BaseDeleteController
{
    public function __construct(protected MovementTransferDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
