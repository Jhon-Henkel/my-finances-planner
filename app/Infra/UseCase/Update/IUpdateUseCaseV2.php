<?php

namespace App\Infra\UseCase\Update;

interface IUpdateUseCaseV2
{
    public function execute(array $data, int $id): array;
}
