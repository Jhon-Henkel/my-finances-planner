<?php

namespace App\Services;

use App\DTO\CreditCardDTO;
use App\Repositories\CreditCardRepository;

class CreditCardService extends BasicService
{
    protected CreditCardRepository $repository;

    public function __construct(CreditCardRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): CreditCardRepository
    {
        return $this->repository;
    }

    /**
     * @return CreditCardDTO[]
     */
    public function findAll(): array
    {
        $creditCardTransactionService = app(CreditCardTransactionService::class);
        $items = parent::findAll();
        $itemsWithNextInstallmentValue = [];
        foreach ($items as $item) {
            $invoice = $creditCardTransactionService->getNextInvoiceValueAndTotalValueByCardId($item->getId());
            $item->setTotalValueSpending($invoice['totalValue']);
            $item->setNextInvoiceValue($invoice['nextInvoiceValue']);
            $itemsWithNextInstallmentValue[] = $item;
        }
        return $itemsWithNextInstallmentValue;
    }
}