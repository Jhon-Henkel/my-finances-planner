<?php

namespace App\Infra\Shared\UseCase\Show;

interface IShowUseCase
{
    public function execute(int $id): array;
}
