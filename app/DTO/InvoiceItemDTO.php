<?php

namespace App\DTO;

class InvoiceItemDTO
{
    private int $id;
    private int $countId;
    private null|string $countName;
    private string $description;
    private float $value;
    private string $nextInstallment;
    private int $installments;

    public function __construct(
        int $id,
        int $countId,
        null|string $countName,
        string $description,
        float $value,
        string $nextInstallment,
        int $installments
    ) {
        $this->setId($id);
        $this->setCountId($countId);
        $this->setCountName($countName);
        $this->setDescription($description);
        $this->setValue($value);
        $this->setNextInstallment($nextInstallment);
        $this->setInstallments($installments);
    }

    public function getId(): int
    {
        return $this->id;
    }

    protected function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCountId(): int
    {
        return $this->countId;
    }

    protected function setCountName(null|string $countName): void
    {
        $this->countName = $countName;
    }

    public function getCountName(): null|string
    {
        return $this->countName;
    }

    protected function setCountId(int $countId): void
    {
        $this->countId = $countId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    protected function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    protected function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getNextInstallment(): string
    {
        return $this->nextInstallment;
    }

    public function getNextInstallmentMonth(): int
    {
        return substr($this->nextInstallment, 5, 2);
    }

    protected function setNextInstallment(string $nextInstallment): void
    {
        $this->nextInstallment = $nextInstallment;
    }

    public function getInstallments(): int
    {
        return $this->installments;
    }

    protected function setInstallments(int $installments): void
    {
        $this->installments = $installments;
    }
}