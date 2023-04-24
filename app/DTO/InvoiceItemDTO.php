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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    protected function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCountId(): int
    {
        return $this->countId;
    }

    /**
     * @param string|null $countName
     */
    protected function setCountName(?string $countName): void
    {
        $this->countName = $countName;
    }

    /**
     * @return string|null
     */
    public function getCountName(): ?string
    {
        return $this->countName;
    }

    /**
     * @param int $countId
     */
    protected function setCountId(int $countId): void
    {
        $this->countId = $countId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    protected function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    protected function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getNextInstallment(): string
    {
        return $this->nextInstallment;
    }

    /**
     * @return int
     */
    public function getNextInstallmentMonth(): int
    {
        return substr($this->nextInstallment, 5, 2);
    }

    /**
     * @param string $nextInstallment
     */
    protected function setNextInstallment(string $nextInstallment): void
    {
        $this->nextInstallment = $nextInstallment;
    }

    /**
     * @return int
     */
    public function getInstallments(): int
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     */
    protected function setInstallments(int $installments): void
    {
        $this->installments = $installments;
    }
}