<?php

namespace App\Modules\Movements\Controller\DeleteTransfer;

use App\Infra\Controller\Delete\BaseDeleteController;
use App\Infra\Shared\UseCase\Delete\IDeleteUseCase;
use App\Modules\Movements\UseCase\DeleteTransfer\MovementTransferDeleteUseCase;

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
