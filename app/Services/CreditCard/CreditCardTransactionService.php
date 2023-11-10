<?php

namespace App\Services\CreditCard;

use App\Enums\DateEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\CreditCard\CreditCardTransactionRepository;
use App\Resources\CreditCard\CreditCardResource;
use App\Services\BasicService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarTools;
use App\VO\InvoiceVO;
use Exception;

class CreditCardTransactionService extends BasicService
{
    protected CreditCardTransactionRepository $repository;
    protected CreditCardResource $resource;
    protected CreditCardMovementService $creditCardMovementService;
    protected CreditCardService $creditCardService;
    protected MovementService $movementService;

    public function __construct(
        CreditCardTransactionRepository $repository,
        CreditCardMovementService $creditCardMovementService,
        CreditCardService $creditCardService,
        MovementService $movementService
    ) {
        $this->repository = $repository;
        $this->resource = new CreditCardResource();
        $this->creditCardMovementService = $creditCardMovementService;
        $this->creditCardService = $creditCardService;
        $this->movementService = $movementService;
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
            if (! $invoice->$installment) {
                continue;
            }
            $launchMovementAndUpdateWallet = true;
            $totalValue += $invoice->$installment;
            $transaction = $this->findById($invoice->id);
            $this->creditCardMovementService->insertMovementByTransaction($transaction, $cardId);
            $remainingInstallments = $transaction->getInstallments() - 1;
            if ($remainingInstallments === 0) {
                $this->deleteById($transaction->getId());
                continue;
            }
            $transaction->setInstallments($remainingInstallments < 0 ? 0 : $transaction->getInstallments() - 1);
            $nextInstallment = $this->getNextPaymentDateByInstallment($transaction->getNextInstallment());
            $transaction->setNextInstallment($nextInstallment);
            $this->update($transaction->getId(), $transaction);
        }
        if (! $launchMovementAndUpdateWallet) {
            return false;
        }
        $card = $this->creditCardService->findById($cardId);
        return $this->movementService->launchMovementForCreditCardInvoicePay($walletId, $totalValue, $card->getName());
    }

    /**
     * @param InvoiceVO[] $invoices
     * @return null|string
     */
    protected function getNextInstallmentOrder(array $invoices): null|string
    {
        foreach ($invoices as $invoice) {
            if ($invoice->firstInstallment) {
                return 'firstInstallment';
            } elseif ($invoice->secondInstallment) {
                return 'secondInstallment';
            } elseif ($invoice->thirdInstallment) {
                return 'thirdInstallment';
            } elseif ($invoice->fourthInstallment) {
                return 'fourthInstallment';
            } elseif ($invoice->fifthInstallment) {
                return 'fifthInstallment';
            } elseif ($invoice->sixthInstallment) {
                return 'sixthInstallment';
            }
            return null;
        }
        return null;
    }

    protected function getNextPaymentDateByInstallment(string $nextInstallment): string
    {
        $format = DateEnum::USA_DATE_FORMAT_WITHOUT_TIME;
        return CalendarTools::addMonthInDate($nextInstallment, 1, $format);
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
        $period = CalendarTools::getThisYearPeriod();
        $transactions = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($transactions as $transaction) {
            $total += ($transaction->getValue() * ($transaction->getInstallments() == 0 ? 1 : $transaction->getInstallments()));
        }
        return $total;
    }

    public function getThisMonthInvoiceSum(): float
    {
        $period = CalendarTools::getThisMonthPeriod();
        $transactions = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($transactions as $transaction) {
            $total += $transaction->getValue();
        }
        return $total;
    }

    public function getAllCardsInvoices(): array
    {
        $transactions = $this->getRepository()->findAllToArray();
        $transactionsCards = [];
        foreach ($transactions as $transaction) {
            $transactionsCards[$transaction['credit_card_id']][] = $transaction;
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

    public function isThisMonthInvoicePaid(int $cardId): bool
    {
        $period = CalendarTools::getThisMonthPeriod();
        $isThisMonthInvoicePaid = $this->getRepository()->countByPeriod($period, $cardId);
        return $isThisMonthInvoicePaid === 0;
    }
}