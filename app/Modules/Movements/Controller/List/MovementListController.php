<?php

namespace App\Modules\Movements\Controller\List;

use App\Infra\Controller\List\BaseListController;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Modules\Movements\UseCase\List\MovementListUseCase;

class MovementListController extends BaseListController
{
    public function __construct(protected MovementListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
