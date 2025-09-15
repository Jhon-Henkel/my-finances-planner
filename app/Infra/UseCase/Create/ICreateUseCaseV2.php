<?php

namespace App\Infra\UseCase\Create;

interface ICreateUseCaseV2
{
    public function execute(array $data): array;
}
