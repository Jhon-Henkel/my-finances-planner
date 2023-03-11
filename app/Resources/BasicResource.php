<?php

namespace App\Resources;

abstract class BasicResource implements BasicResourceContract
{
    public abstract function arrayToDto(array $item);
    public abstract function dtoToArray($item): array;
    public abstract function dtoToVo($item);

    public function arrayDtoToVoItens(null|array $itens): array
    {
        if (!$itens) {
            return array();
        }
        $itensResourced = array();
        foreach ($itens as $item) {
            $itensResourced[] = $this->dtoToVo($item);
        }
        return $itensResourced;
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
        return $itensResourced;
    }
}