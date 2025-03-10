<?php

namespace App\Services\Movement;

use App\DTO\FutureMovement\FutureGainDTO;
use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Modules\Wallet\Service\WalletService;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use App\Services\BasicService;
use App\Tools\Calendar\CalendarTools;

class MovementService extends BasicService
{
    public function __construct(
        private readonly MovementRepository $repository,
        private readonly MovementResource $resource,
        private readonly WalletService $walletService,
    ) {
        $walletService->setMovementService($this);
    }

    protected function getRepository(): MovementRepository
    {
        return $this->repository;
    }

    /** @return MovementDTO[] */
    public function findByFilter(array $filterOption): array
    {
        $type = MovementEnum::All->value;
        if (isset($filterOption['type'])) {
            $type = $this->validateType($filterOption['type']);
        }
        $dateRange = CalendarTools::makeDateRangeByDefaultFilterParams($filterOption);
        return $this->repository->findByPeriodAndType($dateRange, $type);
    }

    protected function validateType(null|int $type): int
    {
        if (! $type) {
            return MovementEnum::All->value;
        }
        if (! in_array($type, MovementEnum::getTypesValidForFilter())) {
            return MovementEnum::All->value;
        }
        return $type;
    }

    public function populateByFutureGain(FutureGainDTO $gain): MovementDTO
    {
        $movement = new MovementDTO();
        $movement->setWalletId($gain->getWalletId());
        $movement->setDescription('Recebimento ' . $gain->getDescription());
        $movement->setType(MovementEnum::Gain->value);
        $movement->setAmount($gain->getAmount());
        return $movement;
    }

    public function populateByFutureSpent(FutureSpentDTO $spent): MovementDTO
    {
        $movement = new MovementDTO();
        $movement->setWalletId($spent->getWalletId());
        $movement->setDescription('Pagamento ' . $spent->getDescription());
        $movement->setType(MovementEnum::Spent->value);
        $movement->setAmount($spent->getAmount());
        return $movement;
    }

    public function insert($item)
    {
        $this->walletService->updateWalletValue($item->getAmount(), $item->getWalletId(), $item->getType(), true);
        return parent::insert($item);
    }

    public function launchMovementForWalletUpdate(float $value, int $walletId): bool
    {
        $movement = $this->resource->populateMovementForWalletUpdate($value, $walletId);
        $this->getRepository()->insert($movement);
        return true;
    }

    public function launchMovementForCreditCardInvoicePay(int $walletId, float $totalValue, string $cardName): bool
    {
        $movement = new MovementDTO();
        $movement->setWalletId($walletId);
        $movement->setDescription('Fatura cartão ' . $cardName);
        $movement->setType(MovementEnum::Spent->value);
        $movement->setAmount($totalValue);
        $this->insert($movement);
        return true;
    }

    public function countByWalletId(int $walletId): int
    {
        return $this->getRepository()->countByWalletId($walletId);
    }
}
