<?php

namespace App\Infra\Shared\UseCase\Insert;

interface IInsertUseCase
{
    public function execute(array $data): bool;
}
