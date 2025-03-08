<?php

namespace App\Infra\Shared\UseCase\Update;

interface IUpdateUseCase
{
    public function execute(array $data, int $id): bool;
}
