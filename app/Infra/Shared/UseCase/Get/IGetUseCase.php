<?php

namespace App\Infra\Shared\UseCase\Get;

interface IGetUseCase
{
    public function execute(int $id): array;
}
