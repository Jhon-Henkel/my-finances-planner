<?php

namespace App\Modules\CreditCardInvoice\Controller;

use App\Infra\Controller\Read\BaseListControllerV2;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Modules\CreditCardInvoice\UseCase\CreditCardInvoiceListUseCase;

class CreditCardInvoiceListController extends BaseListControllerV2
{
    public function __construct(private CreditCardInvoiceListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCaseV2
    {
        return $this->useCase;
    }
}
