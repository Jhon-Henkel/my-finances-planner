<?php

namespace App\Services\CreditCard;

use App\DTO\CreditCard\CreditCardMovementDTO;
use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\Enums\MovementEnum;
use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Services\BasicService;

class CreditCardMovementService extends BasicService
{
    protected CreditCardMovementRepository $repository;

    public function __construct(CreditCardMovementRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): CreditCardMovementRepository
    {
        return $this->repository;
    }

    public function insertMovementByTransaction(CreditCardTransactionDTO $transaction, int $creditCardId): void
    {
        $movement = new CreditCardMovementDTO(
            null,
            $creditCardId,
            $transaction->getName(),
            MovementEnum::SPENT,
            $transaction->getValue()
        );
        $this->insert($movement);
    }
}