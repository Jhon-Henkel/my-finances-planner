<?php

namespace App\Modules\CreditCard\UseCase;

use App\Infra\UseCase\Delete\IDeleteUseCase;
use App\Models\CreditCard\CreditCard;

class CreditCardDeleteUseCase implements IDeleteUseCase
{
    public function execute(int $id): void
    {
        CreditCard::find($id)->delete();
    }
}
