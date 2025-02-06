<?php

namespace App\Services\FutureMovement;

use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\FutureMovement\IFutureMovementDTO;
use App\Repositories\FutureSpentRepository;
use App\Services\BasicService;
use App\Services\Movement\MovementService;

class FutureSpentService extends BasicService
{
    use FutureMovementTrait;

    public function __construct(
        private readonly FutureSpentRepository $repository,
        private readonly MovementService $movementService
    ) {
    }

    protected function getRepository(): FutureSpentRepository
    {
        return $this->repository;
    }

    public function paySpent(FutureSpentDTO $spent, array $options): bool
    {
        $isEqualsValue = $options['value'] === $spent->getAmount();
        $isEqualsWallet = $options['walletId'] === $spent->getWalletId();
        $spent->setBankSlipCode('');
        if (! $options['partial'] && $isEqualsValue && $isEqualsWallet) {
            return $this->payFullSpent($spent);
        }
        return $this->payWithOptions($spent, $options);
    }

    protected function payFullSpent(FutureSpentDTO $spent): bool
    {
        $movement = $this->movementService->populateByFutureSpent($spent);
        if (! $this->movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function payWithOptions(FutureSpentDTO $spent, array $options): bool
    {
        $isEqualsValue = $options['value'] === $spent->getAmount();
        $isEqualsWallet = $options['walletId'] === $spent->getWalletId();
        $value = $isEqualsValue ? $spent->getAmount() : $options['value'];
        $walletId = $isEqualsWallet ? $spent->getWalletId() : $options['walletId'];
        if ($options['partial'] && $options['value'] < $spent->getAmount()) {
            $newSpent = $this->makeSpentForParcialPay($spent, $spent->getAmount() - $value);
            $this->insert($newSpent);
        }
        $movement = $this->movementService->populateByFutureSpent($spent);
        $movement->setAmount($value);
        $movement->setWalletId($walletId);
        $description = $movement->getDescription();
        if ($options['partial']) {
            $description = 'Pagamento parcial ' . strtolower($spent->getDescription());
        }
        $movement->setDescription($description);
        if (! $this->movementService->insert($movement)) {
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function makeSpentForParcialPay(FutureSpentDTO $spent, float $value): IFutureMovementDTO
    {
        $description = str_replace('Restante ', '', strtolower($spent->getDescription()));
        return $this->makeFutureMovementForParcialReceive($spent, $value, 'Restante ' . $description);
    }
}
