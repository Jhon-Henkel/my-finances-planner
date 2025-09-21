<?php

namespace App\Modules\CreditCardInvoice\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\CreditCardInvoice\UseCase\CreditCardInvoiceDeleteUseCase;

class CreditCardInvoiceDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private CreditCardInvoiceDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
