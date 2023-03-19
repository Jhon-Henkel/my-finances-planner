<?php

namespace App\Services;

use App\DTO\WalletDTO;
use App\Enums\MovementEnum;
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

    public function updateWalletValue(float $value, int $walletId, int $type): void
    {
        $wallet = $this->findById($walletId);
        $amount = $wallet->getAmount();
        if ($type == MovementEnum::GAIN) {
            $amount += $value;
        } elseif ($type == MovementEnum::SPENT) {
            $amount -= $value;
        }
        $wallet->setAmount($amount);
        $this->update($walletId, $wallet);
    }
}