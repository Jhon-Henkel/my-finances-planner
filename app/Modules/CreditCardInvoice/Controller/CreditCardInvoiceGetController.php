<?php

namespace App\Modules\CreditCardInvoice\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IShowUseCaseV2;
use App\Modules\CreditCardInvoice\UseCase\CreditCardInvoiceGetUseCase;

class CreditCardInvoiceGetController extends BaseGetControllerV2
{
    public function __construct(private CreditCardInvoiceGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IShowUseCaseV2
    {
        return $this->useCase;
    }
}
