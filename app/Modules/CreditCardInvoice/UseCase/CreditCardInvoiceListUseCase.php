<?php

namespace App\Modules\CreditCardInvoice\UseCase;

use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Models\CreditCard\CreditCardInvoice;
use App\Resources\CreditCard\CreditCardInvoiceResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CreditCardInvoiceListUseCase implements IListUseCaseV2
{
    public function execute(int $page, int $perPage, ?string $filter = null): AnonymousResourceCollection
    {
        $query = CreditCardInvoice::with('items');
        if ($filter) {
            $query->where('name', 'like', "%{$filter}%");
        }
        return CreditCardInvoiceResource::collection($query->paginate($perPage, ['*'], 'page', $page));
    }
}
