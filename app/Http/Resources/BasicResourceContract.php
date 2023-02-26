<?php

namespace App\Http\Resources;

interface BasicResourceContract
{
    public function arrayToDto(array $item);
    public function dtoToArray($item);
}
