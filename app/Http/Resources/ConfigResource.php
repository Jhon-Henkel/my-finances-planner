<?php

namespace App\Http\Resources;

use App\DTO\ConfigDTO;

class ConfigResource extends BasicResource
{

    public function arrayToDto(array $item): ConfigDTO
    {
        $dto = new ConfigDTO();
        $dto->setId($item['id'] ?? null);
        $dto->setName($item['name']);
        $dto->setValue($item['value']);
        $dto->setCreatedAt($item['created_at'] ?? null);
        $dto->setUpdatedAt($item['updated_at'] ?? null);
        return $dto;
    }

    /** @var ConfigDTO $item */
    public function dtoToArray($item): array
    {
        return array(
            'name' => $item->getName(),
            'value' => $item->getValue(),
        );
    }

    public function dtoToVo($item)
    {
        // TODO: Implement dtoToVo() method.
    }

    /**
     * @param array $itens
     * @return mixed
     */
    public function arrayToDtoItens(array $itens): mixed
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

    public function arrayDtoToVoItens(array $itens): array
    {
        // TODO: Implement arrayDtoToVoItens() method.
    }
}