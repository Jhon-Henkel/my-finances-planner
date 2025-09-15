<?php

namespace App\Modules\CreditCard\UseCase;

use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Models\CreditCard\CreditCard;

class CreditCardUpdateUseCase implements IUpdateUseCaseV2
{
    public function execute(array $data, int $id): array
    {
        $item = CreditCard::findOrFail($id);

        $item->update([
            'name' => $data['name'],
            'limit' => $data['limit'],
            'due_date' => $data['dueDate'],
            'closing_day' => $data['closingDay'],
            'status' => $data['status'],
        ]);

        return $item->toArray();
    }
}
