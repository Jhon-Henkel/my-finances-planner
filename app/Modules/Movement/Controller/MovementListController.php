<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Movement\UseCase\MovementListUseCase;

class MovementListController extends BaseListController
{
    public function __construct(private MovementListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
