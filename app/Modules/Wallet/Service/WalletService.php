<?php

namespace App\Modules\Wallet\Service;

use App\Enums\MovementEnum;
use App\Exceptions\ConstraintException;
use App\Modules\Wallet\DTO\WalletDTO;
use App\Modules\Wallet\Repository\WalletRepository;
use App\Services\BasicService;
use App\Services\Movement\MovementService;

/**
 * @method WalletDTO[] findAll()
 */
class WalletService extends BasicService
{
    private MovementService $movementService;

    public function __construct(
        private readonly WalletRepository $repository
    ) {
    }

    protected function getRepository(): WalletRepository
    {
        return $this->repository;
    }

    public function setMovementService(MovementService $movementService): void
    {
        $this->movementService = $movementService;
    }

    public function getMovementService(): MovementService
    {
        if (! isset($this->movementService)) {
            $this->setMovementService(app(MovementService::class));
        }
        return $this->movementService;
    }

    /** @return WalletDTO[] */
    public function findAllByType(int $type): array
    {
        return $this->repository->findAllByType($type);
    }

    public function updateWalletValue(float $value, int $walletId, int $type, bool $movementAlreadyDone): void
    {
        $wallet = $this->findById($walletId);
        $amount = $wallet->getAmount();
        if ($type == MovementEnum::Gain->value) {
            $amount += $value;
        } elseif ($type == MovementEnum::Spent->value) {
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
            $this->getMovementService()->launchMovementForWalletUpdate($difference, $wallet->getId());
        }
        return parent::update($id, $item);
    }

    public function getTotalWalletValue(): float
    {
        $wallets = $this->findAll();
        $total = 0;
        foreach ($wallets as $wallet) {
            if ($wallet->mustHideValue() || $wallet->isInactive()) {
                continue;
            }
            $total += $wallet->getAmount();
        }
        return $total;
    }

    /** @throws ConstraintException */
    public function deleteById(int $id)
    {
        if ($this->getMovementService()->countByWalletId($id) > 0) {
            throw new ConstraintException('Não é possível excluir uma carteira que possui movimentações!');
        }
        return parent::deleteById($id);
    }
}
