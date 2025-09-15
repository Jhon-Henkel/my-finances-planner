<?php

namespace App\Modules\CreditCard\Controller;

use App\Infra\Controller\Read\BaseListControllerV2;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Modules\CreditCard\UseCase\CreditCardListUseCase;

class CreditCardListController extends BaseListControllerV2
{
    public function __construct(private CreditCardListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCaseV2
    {
        return $this->useCase;
    }
}
