<?php

namespace App\Modules\Old\Movements\Controller\List;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Old\Movements\UseCase\List\MovementListUseCase;

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
