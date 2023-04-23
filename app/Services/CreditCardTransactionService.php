<?php

namespace App\Services;

use App\Enums\BasicFieldsEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\CreditCardTransactionRepository;
use App\Resources\CreditCardResource;
use App\Tools\CalendarTools;
use App\VO\InvoiceVO;

class CreditCardTransactionService extends BasicService
{
    protected CreditCardTransactionRepository $repository;
    protected CreditCardResource $resource;

    public function __construct(CreditCardTransactionRepository $repository)
    {
        $this->repository = $repository;
        $this->resource = app(CreditCardResource::class);
    }

    protected function getRepository(): CreditCardTransactionRepository
    {
        return $this->repository;
    }

    /**
     * @param int $cardId
     * @return InvoiceVO[]
     */
    public function getInvoices(int $cardId): array
    {
        $transactions = $this->getRepository()->getExpenses($cardId);
        $invoices = [];
        foreach ($transactions as $transaction) {
            $expenseDTO = $this->resource->transactionToInvoiceDTO($transaction);
            $invoices[] = InvoiceFactory::factoryInvoice($expenseDTO, CalendarTools::getThisMonth());
        }
        return $invoices;
    }

    public function payInvoice(int $cardId, int $month): bool
    {
        $date = CalendarTools::mountDateToPayInvoice($month, CalendarTools::getDateNow());
        $expenses = $this->getRepository()->getExpensesByCardIdAndMonth($cardId, $date);
        $allPaid = true;
        foreach ($expenses as $expense) {
            $nextInstallment = CalendarTools::getNextInstallment($expense[BasicFieldsEnum::NEXT_INSTALLMENT_DB]);
            $expense[BasicFieldsEnum::NEXT_INSTALLMENT_DB] = $nextInstallment;
            if (! $this->getRepository()->payExpense($expense)) {
                $allPaid = false;
            }
            if (! $allPaid) {
                break;
            }
        }
        return $allPaid;
    }
}