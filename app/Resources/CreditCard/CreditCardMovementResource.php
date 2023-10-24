<?php

namespace App\Resources\CreditCard;

use App\DTO\CreditCard\CreditCardMovementDTO;
use App\DTO\Movement\MovementDTO;
use App\Exceptions\NotImplementedException;
use App\Resources\BasicResource;

class CreditCardMovementResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardMovementDTO
    {
        return new CreditCardMovementDTO(
            $item['id'] ?? null,
            $item['credit_card_id'],
            $item['description'],
            $item['type'],
            $item['amount'],
            $item['created_at'] ?? null,
            $item['updated_at'] ?? null
        );
    }

    public function dtoToArray($item): array
    {
        return [
            'credit_card_id' => $item->getCreditCardId(),
            'description' => $item->getDescription(),
            'type' => $item->getType(),
            'amount' => $item->getAmount()
        ];
    }

    public function dtoToVo($item)
    {
        throw new NotImplementedException();
    }

    /**
     * @param CreditCardMovementDTO[] $creditCardMovement
     * @return MovementDTO[]
     */
    public function convertCreditCardMovementsToMovements(array $creditCardMovement): array
    {
        $movements = [];
        foreach ($creditCardMovement as $movement) {
            $movementDto = new MovementDTO();
            $movementDto->setId($movement->getId());
            $movementDto->setType($movement->getType());
            $movementDto->setDescription($movement->getDescription());
            $movementDto->setAmount($movement->getAmount());
            $movementDto->setCreatedAt($movement->getCreatedAt());
            $movementDto->setUpdatedAt($movement->getUpdatedAt());
            $movements[] = $movement;
        }
        return $movements;
    }
}