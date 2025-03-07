<?php

namespace App\Modules\CreditCardInvoice\UseCase\List;

use App\Enums\RouteEnum;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Models\CreditCardTransaction;
use App\Modules\CreditCardInvoice\Exceptions\CreditCardIdNotFountInRoute;
use App\Modules\Invoice\Service\InvoiceListService;

class CreditCardInvoiceListUseCase implements IListUseCase
{
    public function __construct(protected InvoiceListService $invoiceService)
    {
    }

    public function execute(int $perPage, int $page, ?array $queryParams = null): array
    {
        $this->invoiceService->validateFilterDateQueryParams($queryParams);
        $result = $this->getList(999999, $page, $queryParams);
        $this->invoiceService->addPaginationUrls(
            $result,
            RouteEnum::ApiCreditCardInvoiceList,
            $queryParams,
            ['credit_card_id' => request()->route('credit_card_id')]
        );
        $this->invoiceService->addMetaData($result, $queryParams);
        $result['total'] = count($result['data']);
        return $result;
    }

    protected function getList(int $perPage, int $page, array $queryParams): array
    {
        $creditCardId = request()->route('credit_card_id');
        CreditCardIdNotFountInRoute::throwIfNot(is_numeric($creditCardId));
        $invoiceItems = CreditCardTransaction::query()
            ->select('*')
            ->where('credit_card_id', $creditCardId)
            ->orderByRaw('DAY(next_installment)')
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
        $this->filterInvoiceItems($invoiceItems, $queryParams);
        return $invoiceItems;
    }

    protected function filterInvoiceItems(array &$invoiceItems, array $queryParams): void
    {
        $itemsFilter = [];
        foreach ($invoiceItems['data'] as $invoiceItem) {
            if ($this->invoiceService->creditCardTransactionItemBelongsToInvoice($invoiceItem, $queryParams)) {
                $itemsFilter[] = $invoiceItem;
            }
        }
        foreach ($itemsFilter as $key => $item) {
            $itemsFilter[$key]['forecast'] = $item['next_installment'];
            $itemsFilter[$key]['amount'] = $item['value'];
            $itemsFilter[$key]['description'] = $item['name'];
            unset($itemsFilter[$key]['next_installment'], $itemsFilter[$key]['value'], $itemsFilter[$key]['name']);
        }
        $invoiceItems['data'] = $itemsFilter;
    }
}
