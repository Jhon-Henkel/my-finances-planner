<?php

namespace App\Infra\Shared\UseCase\Delete;

interface IDeleteUseCase
{
    public function execute(int $id): void;
}
