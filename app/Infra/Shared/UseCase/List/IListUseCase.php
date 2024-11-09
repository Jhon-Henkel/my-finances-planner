<?php

namespace App\Infra\Shared\UseCase\List;

interface IListUseCase
{
    public function execute(int $perPage, int $page, array|null $queryParams = null): array;
}
