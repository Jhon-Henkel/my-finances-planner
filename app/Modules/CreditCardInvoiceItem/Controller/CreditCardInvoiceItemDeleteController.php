<?php

namespace App\Modules\CreditCardInvoiceItem\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCaseV2;
use App\Modules\CreditCardInvoiceItem\UseCase\CreditCardInvoiceItemDeleteUseCase;

class CreditCardInvoiceItemDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private CreditCardInvoiceItemDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCaseV2
    {
        return $this->useCase;
    }
}
