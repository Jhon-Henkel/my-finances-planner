<?php

namespace App\Modules\CreditCardInvoice\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\CreditCardInvoice\UseCase\CreditCardInvoiceGetUseCase;

class CreditCardInvoiceGetController extends BaseGetControllerV2
{
    public function __construct(private CreditCardInvoiceGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
