<?php

namespace App\Modules\CreditCard\Controller;

use App\Infra\Controller\Delete\BaseDeleteControllerV2;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Modules\CreditCard\UseCase\CreditCardDeleteUseCase;

class CreditCardDeleteController extends BaseDeleteControllerV2
{
    public function __construct(private CreditCardDeleteUseCase $useCase)
    {
    }

    protected function getUseCase(): IDeleteUseCase
    {
        return $this->useCase;
    }
}
