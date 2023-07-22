<?php

namespace App\Services;

use App\DTO\InvoiceItemDTO;
use App\Factory\InvoiceFactory;
use App\Services\CreditCard\CreditCardTransactionService;
use App\VO\InvoiceVO;

class PanoramaService
{
    public function getPanoramaData(): array
    {
        $totalFutureExpenses = InvoiceFactory::generateInvoiceSumFromInvoicesArray($this->getTotalFutureExpenses());
        $totalFutureGains = $this->getTotalFutureGains();
        $totalCreditCardExpenses = $this->getTotalCreditCardExpenses();
        return [
            'totalWalletValue' => $this->getWalletInvoiceData(),
            'futureExpenses' => $this->getTotalFutureExpenses(),
            'totalFutureExpenses' => $totalFutureExpenses,
            'totalFutureGains' => $totalFutureGains,
            'totalCreditCardExpenses' => $totalCreditCardExpenses,
            'totalLeft' => $this->getTotalLeft($totalFutureExpenses, $totalFutureGains, $totalCreditCardExpenses),
        ];
    }

    protected function getWalletInvoiceData(): float
    {
        $walletService = app(WalletService::class);
        return $walletService->getTotalWalletValue();
    }

    protected function getTotalFutureExpenses()
    {
        $invoiceService = app(FutureSpentService::class);
        return $invoiceService->getNextSixMonthsFutureSpent();
    }

    protected function getTotalFutureGains(): InvoiceVO
    {
        $gainService = app(FutureGainService::class);
        $gains = $gainService->getNextSixMonthsFutureGain();
        return InvoiceFactory::generateInvoiceSumFromInvoicesArray($gains);
    }

    protected function getTotalCreditCardExpenses(): InvoiceVO
    {
        $creditCardTransactionService = app(CreditCardTransactionService::class);
        $invoices = $creditCardTransactionService->getAllCardsInvoices();
        return InvoiceFactory::generateInvoiceSumFromInvoicesArray($invoices);
    }

    protected function getTotalLeft(InvoiceVO $expenses, InvoiceVO $gains, InvoiceVO $creditCardExpenses): InvoiceVO
    {
        $totalLeft = [
            0 => $gains->firstInstallment - ($expenses->firstInstallment + $creditCardExpenses->firstInstallment),
            1 => $gains->secondInstallment - ($expenses->secondInstallment + $creditCardExpenses->secondInstallment),
            2 => $gains->thirdInstallment - ($expenses->thirdInstallment + $creditCardExpenses->thirdInstallment),
            3 => $gains->forthInstallment - ($expenses->forthInstallment + $creditCardExpenses->forthInstallment),
            4 => $gains->fifthInstallment - ($expenses->fifthInstallment + $creditCardExpenses->fifthInstallment),
            5 => $gains->sixthInstallment - ($expenses->sixthInstallment + $creditCardExpenses->sixthInstallment),
        ];
        $invoiceDto = new InvoiceItemDTO(0, 0, null, 'SumTotalLeft', 0, 0, 0);
        return InvoiceVO::makeInvoice($invoiceDto, $totalLeft, 0);
    }
}