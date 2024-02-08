<?php

namespace App\Services\CreditCard;

use App\DTO\CreditCard\CreditCardDTO;
use App\Enums\DateFormatEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\CreditCard\CreditCardTransactionRepository;
use App\Resources\CreditCard\CreditCardResource;
use App\Services\BasicService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarTools;
use App\VO\InvoiceVO;

class CreditCardTransactionService extends BasicService
{
    protected CreditCardResource $resource;

    public function __construct(
        private readonly CreditCardTransactionRepository $repository,
        private readonly CreditCardMovementService $creditCardMovementService,
        private readonly MovementService $movementService
    ) {
        $this->resource = new CreditCardResource();
    }

    protected function getRepository(): CreditCardTransactionRepository
    {
        return $this->repository;
    }

    public function payInvoice(CreditCardDTO $card, int $walletId): bool
    {
        $invoices = $this->getInvoices($card);
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
            $this->creditCardMovementService->insertMovementByTransaction($transaction, $card->getId());
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
        return $this->movementService->launchMovementForCreditCardInvoicePay($walletId, $totalValue, $card->getName());
    }

    /** @param InvoiceVO[] $invoices */
    protected function getNextInstallmentOrder(array $invoices): null|string
    {
        $firstInstallment = null;
        $secondInstallment = null;
        $thirdInstallment = null;
        $fourthInstallment = null;
        $fifthInstallment = null;
        $sixthInstallment = null;
        foreach ($invoices as $invoice) {
            if ($invoice->firstInstallment) {
                $firstInstallment = true;
            } elseif ($invoice->secondInstallment) {
                $secondInstallment = true;
            } elseif ($invoice->thirdInstallment) {
                $thirdInstallment = true;
            } elseif ($invoice->fourthInstallment) {
                $fourthInstallment = true;
            } elseif ($invoice->fifthInstallment) {
                $fifthInstallment = true;
            } elseif ($invoice->sixthInstallment) {
                $sixthInstallment = true;
            }
        }
        if ($firstInstallment) {
            return 'firstInstallment';
        } elseif ($secondInstallment) {
            return 'secondInstallment';
        } elseif ($thirdInstallment) {
            return 'thirdInstallment';
        } elseif ($fourthInstallment) {
            return 'fourthInstallment';
        } elseif ($fifthInstallment) {
            return 'fifthInstallment';
        } elseif ($sixthInstallment) {
            return 'sixthInstallment';
        }
        return null;
    }

    protected function getNextPaymentDateByInstallment(string $nextInstallment): string
    {
        $format = DateFormatEnum::UsaDateFormatWithoutTime->value;
        return CalendarTools::addMonthInDate($nextInstallment, 1, $format);
    }

    /** @return InvoiceVO[] */
    public function getInvoices(CreditCardDTO $card): array
    {
        $invoice = [];
        $transactions = $this->getRepository()->getExpenses($card->getId());
        $thisMonth = CalendarTools::getThisMonth();
        foreach ($transactions as $transaction) {
            $expenseDTO = $this->resource->transactionToInvoiceDTO($transaction);
            $invoice[] = InvoiceFactory::factoryInvoice($expenseDTO, $thisMonth);
        }
        return $this->orderInvoiceItensByClosingDay($invoice, $card);
    }

    /**
     * @param InvoiceVO[] $invoice
     * @return InvoiceVO[]
     */
    protected function orderInvoiceItensByClosingDay(array $invoice, CreditCardDTO $card): array
    {
        foreach ($invoice as $key => $invoiceItem) {
            if ($card->getClosingDay() < $invoiceItem->nextInstallmentDay) {
                $invoiceItem->sixthInstallment = $invoiceItem->fifthInstallment;
                $invoiceItem->fifthInstallment = $invoiceItem->fourthInstallment;
                $invoiceItem->fourthInstallment = $invoiceItem->thirdInstallment;
                $invoiceItem->thirdInstallment = $invoiceItem->secondInstallment;
                $invoiceItem->secondInstallment = $invoiceItem->firstInstallment;
                $invoiceItem->firstInstallment = null;
            }
            $invoice[$key] = $invoiceItem;
        }
        return $invoice;
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

    public function getAllNextInvoicesValuesAndTotalValues(): array
    {
        $invoicesGrouped = $this->getAllCardsInvoicesGroupedByCardId();
        $invoicesValues = [];
        foreach ($invoicesGrouped as $cardId => $invoices) {
            $nextInstallment = $this->getNextInstallmentOrder($invoices);
            if (! $nextInstallment) {
                $invoicesValues[$cardId] = ['nextValue' => 0, 'totalValue' => 0, 'thisMonthInvoicePayed' => true];
                continue;
            }
            $nextInvoiceValue = 0;
            $totalValue = 0;
            foreach ($invoices as $invoice) {
                $numberInstallments = $invoice->remainingInstallments === 0 ? 1 : $invoice->remainingInstallments;
                $totalValue += ($invoice->$nextInstallment * $numberInstallments);
                $nextInvoiceValue += $invoice->$nextInstallment;
            }
            $thisMonthInvoicePayed = $this->isThisMonthInvoicePayed($nextInstallment);
            $invoicesValues[$cardId] = [
                'nextValue' => $nextInvoiceValue,
                'totalValue' => $totalValue,
                'thisMonthInvoicePayed' => $thisMonthInvoicePayed
            ];
        }
        return $invoicesValues;
    }

    public function getAllCardsInvoicesGroupedByCardId(): array
    {
        $allInvoices = $this->getAllCardsInvoices();
        $invoices = [];
        foreach ($allInvoices as $invoice) {
            $invoices[$invoice->countId][] = $invoice;
        }
        return $invoices;
    }

    protected function isThisMonthInvoicePayed(null|string $nextInstallment): bool
    {
        return $nextInstallment !== 'firstInstallment';
    }

    public function countByCreditCardId(int $creditCardId): int
    {
        return $this->getRepository()->countByCreditCardId($creditCardId);
    }
}