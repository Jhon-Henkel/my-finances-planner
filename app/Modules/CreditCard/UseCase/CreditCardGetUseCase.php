<?php

namespace App\Modules\CreditCard\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\CreditCard\CreditCard;

class CreditCardGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return CreditCard::findOrFail($id)->toArray();
    }
}
