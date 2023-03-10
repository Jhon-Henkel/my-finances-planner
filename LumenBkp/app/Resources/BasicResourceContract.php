<?php

namespace App\Resources;

interface BasicResourceContract
{
    public function arrayToDto(array $item);
    public function dtoToArray($item);
    public function dtoToVo($item);
    public function arrayToDtoItens(array $itens): mixed;
    public function arrayDtoToVoItens(array $itens): array;
}