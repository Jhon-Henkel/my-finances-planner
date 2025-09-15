<?php

namespace App\Modules\Old\CreditCardInvoice\Controller\List;

use App\Infra\Controller\Read\BaseListController;
use App\Infra\UseCase\Read\IListUseCase;
use App\Modules\Old\CreditCardInvoice\UseCase\List\CreditCardInvoiceListUseCase;

class CreditCardInvoiceListController extends BaseListController
{
    public function __construct(protected CreditCardInvoiceListUseCase $useCase)
    {
    }

    protected function getUseCase(): IListUseCase
    {
        return $this->useCase;
    }
}
