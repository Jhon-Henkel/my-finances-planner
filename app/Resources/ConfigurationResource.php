<?php

namespace App\Resources;

use App\DTO\ConfigurationDTO;
use App\Enums\BasicFieldsEnum;

class ConfigurationResource extends BasicResource
{

    public function arrayToDto(array $item): ConfigurationDTO
    {
        $dto = new ConfigurationDTO();
        $dto->setId($item[BasicFieldsEnum::ID] ?? null);
        $dto->setName($item[BasicFieldsEnum::NAME]);
        $dto->setValue($item[BasicFieldsEnum::VALUE]);
        $dto->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $dto->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $dto;
    }

    /** @var ConfigurationDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::VALUE => $item->getValue(),
        );
    }

    public function dtoToVo($item)
    {

    }

    public function arrayToDtoItens(null|array $itens): mixed
    {
        if (!$itens) {
            return array();
        }
        $itensResourced = array();
        foreach ($itens as $item) {
            $itensResourced[] = $this->arrayToDto($item);
        }
        return reset($itensResourced);
    }
}