<?php

namespace App\Services;

use App\Factory\InvoiceFactory;
use App\Repositories\CreditCardTransactionRepository;
use App\Resources\CreditCardResource;
use App\Tools\CalendarTools;
use App\VO\InvoiceVO;
use Exception;

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
     * @throws Exception
     */
    public function payInvoice(int $cardId, int $walletId): bool
    {
        $invoices = $this->getInvoices($cardId);
        $totalValue = 0;
        $launchMovementAndUpdateWallet = false;
        $installment = $this->getNextInstallmentOrder($invoices);
        foreach ($invoices as $invoice) {
            if (! $invoice->$installment){
                continue;
            }
            $launchMovementAndUpdateWallet = true;
            $totalValue += $invoice->$installment;
            $transaction = $this->findById($invoice->id);
            $remainingInstallments = $transaction->getInstallments() - 1;
            if ($remainingInstallments === 0) {
                $this->deleteById($transaction->getId());
                continue;
            }
            $transaction->setInstallments($remainingInstallments < 0 ? 0 : $transaction->getInstallments() - 1);
            $transaction->setNextInstallment(CalendarTools::addMonthInDate($transaction->getNextInstallment(), 1));
            $this->update($transaction->getId(), $transaction);
        }
        if (! $launchMovementAndUpdateWallet) {
            return false;
        }
        $card = app(CreditCardService::class)->getRepository()->findById($cardId);
        app(MovementService::class)->launchMovementForCreditCardInvoicePay($walletId, $totalValue, $card->getName());
        return true;
    }

    /**
     * @param InvoiceVO[] $invoices
     * @return null|string
     */
    protected function getNextInstallmentOrder(array $invoices): null|string
    {
        foreach ($invoices as $invoice) {
            if ($invoice->firstInstallment){
                return 'firstInstallment';
            } elseif ($invoice->secondInstallment){
                return 'secondInstallment';
            } elseif ($invoice->thirdInstallment){
                return 'thirdInstallment';
            } elseif ($invoice->forthInstallment){
                return 'forthInstallment';
            } elseif ($invoice->fifthInstallment){
                return 'fifthInstallment';
            } elseif ($invoice->sixthInstallment){
                return 'sixthInstallment';
            }
            return null;
        }
        return null;
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

    public function getThisYearInvoiceSum(): float
    {
        $period = CalendarTools::getThisYearPeriod(CalendarTools::getThisYear());
        $transactions = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($transactions as $transaction) {
            $total += ($transaction->getValue() * ($transaction->getInstallments() == 0 ? 1 : $transaction->getInstallments()));
        }
        return $total;
    }

    public function getThisMonthInvoiceSum(): float
    {
        $period = CalendarTools::getThisMonthPeriod(CalendarTools::getThisMonth(), CalendarTools::getThisYear());
        $transactions = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($transactions as $transaction) {
            $total += $transaction->getValue();
        }
        return $total;
    }

    public function getAllCardsInvoices(): array
    {
        $creditCards = app(CreditCardService::class)->getRepository()->findAll();
        $transactionsCards = [];
        foreach ($creditCards as $creditCard) {
            $transactionsCards[] = $this->getRepository()->getExpenses($creditCard->getId());
        }
        $invoices = [];
        foreach ($transactionsCards as $transactionCard) {
            foreach ($transactionCard as $transaction) {
                $expenseDTO = $this->resource->transactionToInvoiceDTO($transaction);
                $invoices[] = InvoiceFactory::factoryInvoice($expenseDTO, CalendarTools::getThisMonth());
            }
        }
        return $invoices;
    }

    public function getNextInvoiceValueAndTotalValueByCardId(int $cardId): array
    {
        $invoices = $this->getInvoices($cardId);
        $nextInstallment = $this->getNextInstallmentOrder($invoices);
        if (! $nextInstallment) {
            return ['nextInvoiceValue' => 0, 'totalValue' => 0];
        }
        $nextInvoiceValue = 0;
        $totalValue = 0;
        foreach ($invoices as $invoice) {
            $numberInstallments = $invoice->remainingInstallments === 0 ? 1 : $invoice->remainingInstallments;
            $totalValue += ($invoice->$nextInstallment * $numberInstallments);
            $nextInvoiceValue += $invoice->$nextInstallment;
        }
        return ['nextInvoiceValue' => $nextInvoiceValue, 'totalValue' => $totalValue];
    }

    public function countByCreditCardId(int $creditCardId): int
    {
        return $this->getRepository()->countByCreditCardId($creditCardId);
    }
}