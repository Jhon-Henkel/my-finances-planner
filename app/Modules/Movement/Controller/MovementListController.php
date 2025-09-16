<?php

namespace App\Modules\Movement\Controller;

use App\Infra\Controller\Read\BaseListControllerV2;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Modules\Movement\UseCase\MovementListUseCase;

class MovementListController extends BaseListControllerV2
{
    public function __construct(private MovementListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCaseV2
    {
        return $this->useCase;
    }
}
