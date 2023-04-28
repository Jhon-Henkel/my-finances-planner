<?php

namespace App\Services;

use App\DTO\InvoiceItemDTO;
use App\Factory\InvoiceFactory;
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

    protected function getTotalLeft(InvoiceVO $totalExpenses, InvoiceVO $totalGains, InvoiceVO $totalCardExpenses): InvoiceVO
    {
        $totalLeft = [
            0 => $totalGains->firstInstallment - ($totalExpenses->firstInstallment + $totalCardExpenses->firstInstallment),
            1 => $totalGains->secondInstallment - ($totalExpenses->secondInstallment + $totalCardExpenses->secondInstallment),
            2 => $totalGains->thirdInstallment - ($totalExpenses->thirdInstallment + $totalCardExpenses->thirdInstallment),
            3 => $totalGains->forthInstallment - ($totalExpenses->forthInstallment + $totalCardExpenses->forthInstallment),
            4 => $totalGains->fifthInstallment - ($totalExpenses->fifthInstallment + $totalCardExpenses->fifthInstallment),
            5 => $totalGains->sixthInstallment - ($totalExpenses->sixthInstallment + $totalCardExpenses->sixthInstallment),
        ];
        $invoiceDto = new InvoiceItemDTO(0, 0, null, 'SumTotalLeft', 0, 0, 0);
        return InvoiceVO::makeInvoice($invoiceDto, $totalLeft, 0);
    }
}