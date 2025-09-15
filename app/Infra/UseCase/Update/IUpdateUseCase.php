<?php

namespace App\Infra\UseCase\Update;

/**
 * @deprecated
 */
interface IUpdateUseCase
{
    public function execute(array $data, int $id): bool;
}
