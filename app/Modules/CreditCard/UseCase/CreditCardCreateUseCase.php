<?php

namespace App\Modules\CreditCard\UseCase;

use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Models\CreditCard\CreditCard;

class CreditCardCreateUseCase implements ICreateUseCaseV2
{
    public function execute(array $data): array
    {
        return CreditCard::create([
            'name' => $data['name'],
            'limit' => $data['limit'],
            'due_date' => $data['dueDate'],
            'closing_day' => $data['closingDay'],
            'status' => $data['status'],
        ])->toArray();
    }
}
