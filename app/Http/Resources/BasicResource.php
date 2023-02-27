<?php

namespace App\Http\Resources;

abstract class BasicResource implements BasicResourceContract
{
    public abstract function arrayToDto(array $item);
    public abstract function dtoToArray($item): array;
    public abstract function dtoToVo($item);
    public abstract function arrayToDtoItens(array $itens): mixed;
    public abstract function arrayDtoToVoItens(array $itens): array;
}
