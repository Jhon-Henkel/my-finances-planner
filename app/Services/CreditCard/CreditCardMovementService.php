<?php

namespace App\Services\CreditCard;

use App\DTO\CreditCard\CreditCardMovementDTO;
use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Resources\CreditCard\CreditCardMovementResource;
use App\Services\BasicService;
use App\Tools\Calendar\CalendarTools;

class CreditCardMovementService extends BasicService
{
    public function __construct(
        private readonly CreditCardMovementRepository $repository,
        private readonly CreditCardMovementResource $resource
    ) {
    }

    protected function getRepository(): CreditCardMovementRepository
    {
        return $this->repository;
    }

    protected function getResource(): CreditCardMovementResource
    {
        return $this->resource;
    }

    public function insertMovementByTransaction(CreditCardTransactionDTO $transaction, int $creditCardId): void
    {
        $movement = new CreditCardMovementDTO(
            null,
            $creditCardId,
            $transaction->getName(),
            MovementEnum::Spent->value,
            $transaction->getValue()
        );
        $this->insert($movement);
    }

    /** @return MovementDTO[] */
    public function findByPeriod(array $filterOption): array
    {
        $dateRange = CalendarTools::makeDateRangeByDefaultFilterParams($filterOption);
        $creditCardMovements = $this->getRepository()->findByPeriod($dateRange);
        return $this->getResource()->convertCreditCardMovementsToMovements($creditCardMovements);
    }
}