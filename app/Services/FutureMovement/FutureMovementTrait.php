<?php

namespace App\Services\FutureMovement;

use App\DTO\FutureMovement\IFutureMovementDTO;
use App\Enums\InvoiceInstallmentsEnum;
use App\Tools\Calendar\CalendarTools;

trait FutureMovementTrait
{
    public function makeFutureMovementForParcialReceive(
        IFutureMovementDTO $futureMovement,
        float $value,
        string $description
    ): IFutureMovementDTO {
        $newSpent = clone $futureMovement;
        $newSpent->setId(null);
        $newSpent->setAmount($value);
        $newSpent->setWalletId($futureMovement->getWalletId());
        $newSpent->setInstallments(1);
        $newSpent->setForecast($futureMovement->getForecast());
        $newSpent->setDescription($description);
        $newSpent->setCreatedAt(null);
        $newSpent->setUpdatedAt(null);
        return $newSpent;
    }

    protected function updateRemainingInstallments(IFutureMovementDTO $futureMovement): bool
    {
        $remainingInstallments = $futureMovement->getInstallments() - 1;
        if ($remainingInstallments === 0) {
            return $this->getRepository()->deleteById($futureMovement->getId());
        }
        if ($remainingInstallments < 0) {
            $remainingInstallments = InvoiceInstallmentsEnum::FixedInstallments->value;
        }
        $futureMovement->setInstallments($remainingInstallments);
        $futureMovement->setForecast(CalendarTools::addMonthInDate($futureMovement->getForecast(), 1));
        return (bool)$this->getRepository()->update($futureMovement->getId(), $futureMovement);
    }
}
