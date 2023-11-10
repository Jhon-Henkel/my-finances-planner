<?php

namespace App\Services;

use App\DTO\InvoiceItemDTO;
use App\Factory\InvoiceFactory;
use App\Services\CreditCard\CreditCardTransactionService;
use App\VO\InvoiceVO;
use Exception;

class PanoramaService
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly FutureSpentService $futureSpentService,
        private readonly FutureGainService $futureGainService,
        private readonly CreditCardTransactionService $creditCardTransactionService
    ) {
    }

    /**
     * @throws Exception
     */
    public function getPanoramaData(): array
    {
        $futureExpenses = $this->getTotalFutureExpenses();
        $totalFutureExpenses = InvoiceFactory::generateInvoiceSumFromInvoicesArray($futureExpenses);
        $totalFutureGains = $this->getTotalFutureGains();
        $totalCreditCardExpenses = $this->getTotalCreditCardExpenses();
        return [
            'totalWalletValue' => $this->getWalletInvoiceData(),
            'futureExpenses' => $futureExpenses,
            'totalFutureExpenses' => $totalFutureExpenses,
            'totalFutureGains' => $totalFutureGains,
            'totalCreditCardExpenses' => $totalCreditCardExpenses,
            'totalLeft' => $this->getTotalLeft($totalFutureExpenses, $totalFutureGains, $totalCreditCardExpenses),
        ];
    }

    protected function getWalletInvoiceData(): float
    {
        return $this->walletService->getTotalWalletValue();
    }

    /**
     * @throws Exception
     */
    protected function getTotalFutureExpenses(): array
    {
        return $this->futureSpentService->getNextSixMonthsFutureSpent();
    }

    /**
     * @throws Exception
     */
    protected function getTotalFutureGains(): InvoiceVO
    {
        $gains = $this->futureGainService->getNextSixMonthsFutureGain();
        return InvoiceFactory::generateInvoiceSumFromInvoicesArray($gains);
    }

    protected function getTotalCreditCardExpenses(): InvoiceVO
    {
        $invoices = $this->creditCardTransactionService->getAllCardsInvoices();
        return InvoiceFactory::generateInvoiceSumFromInvoicesArray($invoices);
    }

    protected function getTotalLeft(InvoiceVO $expenses, InvoiceVO $gains, InvoiceVO $creditCardExpenses): InvoiceVO
    {
        $totalLeft = [
            0 => $gains->firstInstallment - ($expenses->firstInstallment + $creditCardExpenses->firstInstallment),
            1 => $gains->secondInstallment - ($expenses->secondInstallment + $creditCardExpenses->secondInstallment),
            2 => $gains->thirdInstallment - ($expenses->thirdInstallment + $creditCardExpenses->thirdInstallment),
            3 => $gains->fourthInstallment - ($expenses->fourthInstallment + $creditCardExpenses->fourthInstallment),
            4 => $gains->fifthInstallment - ($expenses->fifthInstallment + $creditCardExpenses->fifthInstallment),
            5 => $gains->sixthInstallment - ($expenses->sixthInstallment + $creditCardExpenses->sixthInstallment),
        ];
        $invoiceDto = new InvoiceItemDTO(0, 0, null, 'SumTotalLeft', 0, 0, 0);
        return InvoiceVO::makeInvoice($invoiceDto, $totalLeft, 0);
    }
}