<?php

namespace App\Services\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\Exceptions\ConstraintException;
use App\Repositories\CreditCard\CreditCardRepository;
use App\Services\BasicService;

class CreditCardService extends BasicService
{
    public function __construct(
        private readonly CreditCardRepository $repository,
        private readonly CreditCardTransactionService $creditCardTransactionService
    ) {
    }

    protected function getRepository(): CreditCardRepository
    {
        return $this->repository;
    }

    /** @return CreditCardDTO[] */
    public function findAll(): array
    {
        $items = parent::findAll();
        $itemsWithNextInstallmentValue = [];
        $invoices = $this->creditCardTransactionService->getAllNextInvoicesValuesAndTotalValues();
        foreach ($items as $item) {
            $id = $item->getId();
            $item->setTotalValueSpending(isset($invoices[$id]) ? $invoices[$id]['totalValue'] : 0);
            $item->setNextInvoiceValue(isset($invoices[$id]) ? $invoices[$id]['nextValue'] : 0);
            $item->setIsThinsMouthInvoicePayed(isset($invoices[$id]) ? $invoices[$id]['thisMonthInvoicePayed'] : true);
            $itemsWithNextInstallmentValue[] = $item;
        }
        return $itemsWithNextInstallmentValue;
    }

    /** @throws ConstraintException */
    public function deleteById(int $id)
    {
        if ($this->creditCardTransactionService->countByCreditCardId($id) > 0) {
            throw new ConstraintException('Não é possível excluir um cartão que possui fatura!');
        }
        return parent::deleteById($id);
    }
}