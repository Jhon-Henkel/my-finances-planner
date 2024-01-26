<?php

namespace App\Resources;

use App\DTO\ConfigurationDTO;
use App\VO\ConfigurationsVO;

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

    /** @var ConfigurationDTO $item */
    public function dtoToVo($item): ConfigurationsVO
    {
        return ConfigurationsVO::make($item);
    }
}