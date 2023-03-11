<?php

namespace App\Resources;

use App\DTO\ConfigurationDTO;

class ConfigurationResource extends BasicResource
{

    public function arrayToDto(array $item): ConfigurationDTO
    {
        $dto = new ConfigurationDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setName($item['name']);
        $dto->setValue($item['value']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @var ConfigurationDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            'name' => $item->getName(),
            'value' => $item->getValue(),
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