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
    public ?float $firstInstallment;
    public ?float $secondInstallment;
    public ?float $thirdInstallment;
    public ?float $forthInstallment;
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
        $invoice->firstInstallment = $installments[0];
        $invoice->secondInstallment = $installments[1];
        $invoice->thirdInstallment = $installments[2];
        $invoice->forthInstallment = $installments[3];
        $invoice->fifthInstallment = $installments[4];
        $invoice->sixthInstallment = $installments[5];
        $invoice->totalRemainingValue = $remainingValue;
        return $invoice;
    }
}