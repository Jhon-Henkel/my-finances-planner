<?php

namespace App\Resources;

use App\DTO\CreditCardDTO;
use App\Enums\BasicFieldsEnum;
use App\VO\CreditCardVO;

class CreditCardResource extends BasicResource
{
    public function arrayToDto(array $item): CreditCardDTO
    {
        $dto = new CreditCardDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setName($item[BasicFieldsEnum::NAME]);
        $dto->setLimit($item[BasicFieldsEnum::LIMIT]);
        $dto->setDueDate($item[BasicFieldsEnum::DUE_DATE]);
        $dto->setClosingDay($item[BasicFieldsEnum::CLOSING_DAY]);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    public function dtoToArray($item): array
    {
        return [
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::LIMIT => $item->getLimit(),
            BasicFieldsEnum::DUE_DATE => $item->getDueDate(),
            BasicFieldsEnum::CLOSING_DAY => $item->getClosingDay(),
        ];
    }

    public function dtoToVo($item): CreditCardVO
    {
        $vo = new CreditCardVO();
        $vo->id = $item->getId();
        $vo->name = $item->getName();
        $vo->limit = $item->getLimit();
        $vo->dueDate = $item->getDueDate();
        $vo->closingDay = $item->getClosingDay();
        $vo->createdAt = $item->getCreatedAt();
        $vo->updatedAt = $item->getUpdatedAt();
        return $vo;
    }
}