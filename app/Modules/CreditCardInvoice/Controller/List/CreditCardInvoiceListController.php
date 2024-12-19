<?php

namespace App\Modules\CreditCardInvoice\Controller\List;

use App\Infra\Controller\List\BaseListController;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Modules\CreditCardInvoice\UseCase\List\CreditCardInvoiceListUseCase;

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
