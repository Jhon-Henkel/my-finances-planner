<?php

namespace App\Services;

use App\DTO\FutureSpentDTO;
use App\Enums\BasicFieldsEnum;
use App\Enums\InvoiceEnum;
use App\Factory\InvoiceFactory;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use App\Tools\CalendarTools;
use Exception;

class FutureSpentService extends BasicService
{
    protected FutureSpentRepository $repository;
    protected FutureSpentResource $resource;

    public function __construct(FutureSpentRepository $repository)
    {
        $this->repository = $repository;
        $this->resource = app(FutureSpentResource::class);
    }

    protected function getRepository(): FutureSpentRepository
    {
        return $this->repository;
    }

    /**
     * @throws Exception
     */
    public function getNextSixMonthsFutureSpent(): array
    {
        $month = CalendarTools::getThisMonth();
        $year = CalendarTools::getThisYear();
        $period = CalendarTools::getIntervalMonthPeriodByMonthAndYear($month, $year, 6);
        $gains = $this->getRepository()->findByPeriod($period);
        $gainsPackage = [];
        foreach ($gains as $gain) {
            $futureGainDTO = $this->resource->futureGainToInvoiceDTO($gain);
            $gainsPackage[] = InvoiceFactory::factoryInvoice($futureGainDTO, CalendarTools::getThisMonth());
        }
        return $gainsPackage;
    }

    /**
     * @throws Exception
     */
    public function paySpent(FutureSpentDTO $spent, array $options): bool
    {
        $isEqualsValue = $options[BasicFieldsEnum::VALUE] === $spent->getAmount();
        $isEqualsWallet = $options[BasicFieldsEnum::WALLET_ID_JSON] === $spent->getWalletId();
        if (! $options[BasicFieldsEnum::PARTIAL] && $isEqualsValue && $isEqualsWallet) {
            return $this->payFullSpent($spent);
        }
        return $this->payWithOptions($spent, $options);
    }

    protected function payFullSpent(FutureSpentDTO $spent): bool
    {
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureSpent($spent);
        if (! $movementService->insert($movement)){
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function updateRemainingInstallments(FutureSpentDTO $spent): bool
    {
        $remainingInstallments = $spent->getInstallments() - 1;
        if ($remainingInstallments === 0) {
            return $this->getRepository()->deleteById($spent->getId());
        }
        if ($remainingInstallments < 0) {
            $remainingInstallments = InvoiceEnum::FIXED_INSTALLMENTS;
        }
        $spent->setInstallments($remainingInstallments);
        $spent->setForecast(CalendarTools::addMonthInDate($spent->getForecast(), 1));
        return (bool)$this->getRepository()->update($spent->getId(), $spent);
    }

    protected function payWithOptions(FutureSpentDTO $spent, array $options): bool
    {
        $isEqualsValue = $options[BasicFieldsEnum::VALUE] === $spent->getAmount();
        $isEqualsWallet = $options[BasicFieldsEnum::WALLET_ID_JSON] === $spent->getWalletId();
        $value = $isEqualsValue ? $spent->getAmount() : $options[BasicFieldsEnum::VALUE];
        $walletId = $isEqualsWallet ? $spent->getWalletId() : $options[BasicFieldsEnum::WALLET_ID_JSON];
        if ($options[BasicFieldsEnum::PARTIAL] && $options[BasicFieldsEnum::VALUE] < $spent->getAmount()) {
            $newSpent = $this->makeSpentForParcialPay($spent, $spent->getAmount() - $value);
            $this->insert($newSpent);
        }
        $movementService = app(MovementService::class);
        $movement = $movementService->populateByFutureSpent($spent);
        $movement->setAmount($value);
        $movement->setWalletId($walletId);
        $movement->setDescription('Pagamento parcial' . $spent->getDescription());
        if (! $movementService->insert($movement)){
            return false;
        }
        return $this->updateRemainingInstallments($spent);
    }

    protected function makeSpentForParcialPay(FutureSpentDTO $spent, float $value): FutureSpentDTO
    {
        $newSpent = new FutureSpentDTO();
        $newSpent->setId(null);
        $newSpent->setAmount($value);
        $newSpent->setWalletId($spent->getWalletId());
        $newSpent->setInstallments(1);
        $newSpent->setForecast($spent->getForecast());
        $newSpent->setDescription('Restante ' . $spent->getDescription());
        $newSpent->setCreatedAt(null);
        $newSpent->setUpdatedAt(null);
        return $newSpent;
    }

    public function getThisYearFutureSpentSum(): float
    {
        $period = CalendarTools::getThisYearPeriod(CalendarTools::getThisYear());
        $spending = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($spending as $spent) {
            $total += ($spent->getAmount() * ($spent->getInstallments() === 0 ? 1 : $spent->getInstallments()));
        }
        return $total;
    }

    public function getThisMonthFutureSpentSum(): float
    {
        $period = CalendarTools::getThisMonthPeriod(CalendarTools::getThisMonth(), CalendarTools::getThisYear());
        $spending = $this->getRepository()->findByPeriod($period);
        $total = 0;
        foreach ($spending as $spent) {
            $total += $spent->getAmount();
        }
        return $total;
    }
}