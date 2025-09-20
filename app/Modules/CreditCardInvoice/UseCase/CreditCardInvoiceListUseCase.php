<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CreditCardInvoiceListUseCase implements IListUseCaseV2
{
    public function execute(int $page, int $perPage, ?string $filter = null): LengthAwarePaginator
    {
        $query = CreditCardInvoice::query();
        if ($filter) {
            $query->where('name', 'like', "%{$filter}%");
        }
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
