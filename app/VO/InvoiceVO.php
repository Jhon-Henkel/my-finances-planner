<?php

namespace App\VO;

use App\DTO\InvoiceItemDTO;

class InvoiceVO
{
    public int $id;
    public string $name;
    public int $countId;
    public null|string $countName;
    public int $remainingInstallments;
    public int|string $nextInstallmentDay;
    public string $nextInstallmentDate;
    public ?float $firstInstallment;
    public ?float $secondInstallment;
    public ?float $thirdInstallment;
    public ?float $fourthInstallment;
    public ?float $fifthInstallment;
    public ?float $sixthInstallment;
    public ?float $totalRemainingValue;

    public static function makeInvoice(InvoiceItemDTO $item, array $installments, ?float $remainingValue): self
    {
        $invoice = new self();
        $invoice->id = $item->getId();
        $invoice->name = $item->getDescription();
        $invoice->countId = $item->getCountId();
        $invoice->countName = $item->getCountName();
        $invoice->remainingInstallments = $item->getInstallments();
        $invoice->nextInstallmentDay = substr($item->getNextInstallment(), 8, 2);
        $invoice->nextInstallmentDate = $item->getNextInstallment();
        $invoice->firstInstallment = $installments[0] ?? 0;
        $invoice->secondInstallment = $installments[1] ?? 0;
        $invoice->thirdInstallment = $installments[2] ?? 0;
        $invoice->fourthInstallment = $installments[3] ?? 0;
        $invoice->fifthInstallment = $installments[4] ?? 0;
        $invoice->sixthInstallment = $installments[5] ?? 0;
        $invoice->totalRemainingValue = $remainingValue;
        return $invoice;
    }
}