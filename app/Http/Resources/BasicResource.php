<?php

namespace App\Http\Resources;

abstract class BasicResource implements BasicResourceContract
{
    public abstract function arrayToDto(array $item);
    public abstract function dtoToArray($item): array;
}
