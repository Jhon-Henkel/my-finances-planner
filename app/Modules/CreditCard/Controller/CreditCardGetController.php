<?php

namespace App\Modules\CreditCard\Controller;

use App\Infra\Controller\Read\BaseGetControllerV2;
use App\Infra\UseCase\Read\IGetUseCase;
use App\Modules\CreditCard\UseCase\CreditCardGetUseCase;

class CreditCardGetController extends BaseGetControllerV2
{
    public function __construct(private CreditCardGetUseCase $useCase)
    {
    }

    protected function getUseCase(): IGetUseCase
    {
        return $this->useCase;
    }
}
