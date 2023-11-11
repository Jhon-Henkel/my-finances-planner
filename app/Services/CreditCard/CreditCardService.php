<?php

namespace App\Services\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\Exceptions\ConstraintException;
use App\Repositories\CreditCard\CreditCardRepository;
use App\Services\BasicService;

class CreditCardService extends BasicService
{
    public function __construct(
        protected CreditCardRepository $repository,
    ) {
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
        $invoices = $creditCardTransactionService->getAllNextInvoicesValuesAndTotalValues();
        foreach ($items as $item) {
            $id = $item->getId();
            $item->setTotalValueSpending(isset($invoices[$id]) ? $invoices[$id]['totalValue'] : 0);
            $item->setNextInvoiceValue(isset($invoices[$id]) ? $invoices[$id]['nextValue'] : 0);
            $item->setIsThinsMouthInvoicePayed(isset($invoices[$id]) ? $invoices[$id]['thisMonthInvoicePayed'] : true);
            $itemsWithNextInstallmentValue[] = $item;
        }
        return $itemsWithNextInstallmentValue;
    }

    public function deleteById(int $id)
    {
        $transactionService = app(CreditCardTransactionService::class);
        if ($transactionService->countByCreditCardId($id) > 0) {
            throw new ConstraintException('Não é possível excluir um cartão que possui fatura!');
        }
        return parent::deleteById($id);
    }
}