<?php

namespace App\Services;

use App\DTO\WalletDTO;
use App\Enums\MovementEnum;
use App\Exceptions\ConstraintException;
use App\Repositories\WalletRepository;

class WalletService extends BasicService
{
    protected WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): WalletRepository
    {
        return $this->repository;
    }

    /**
     * @param int $type
     * @return WalletDTO[]
     */
    public function findAllByType(int $type): array
    {
        return $this->repository->findAllByType($type);
    }

    public function updateWalletValue(float $value, int $walletId, int $type, bool $movementAlreadyDone): void
    {
        $wallet = $this->findById($walletId);
        $amount = $wallet->getAmount();
        if ($type == MovementEnum::GAIN) {
            $amount += $value;
        } elseif ($type == MovementEnum::SPENT) {
            $amount -= $value;
        }
        $wallet->setAmount($amount);
        $wallet->setMovementAlreadyDone($movementAlreadyDone);
        $this->update($walletId, $wallet);
    }

    public function update(int $id, $item)
    {
        $wallet = $this->findById($id);
        if (! $item->getMovementAlreadyDone() && $wallet->getAmount() != $item->getAmount()) {
            $difference = $item->getAmount() - $wallet->getAmount();
            $movementService = app(MovementService::class);
            $movementService->launchMovementForWalletUpdate($difference, $wallet->getId());
        }
        return parent::update($id, $item);
    }

    public function getTotalWalletValue(): float
    {
        $wallets = $this->findAll();
        $total = 0;
        foreach ($wallets as $wallet) {
            $total += $wallet->getAmount();
        }
        return $total;
    }

    public function deleteById(int $id)
    {
        $movementService = app(MovementService::class);
        if ($movementService->countByWalletId($id) > 0) {
            throw new ConstraintException('Não é possível excluir uma carteira que possui movimentações!');
        }
        return parent::deleteById($id);
    }
}