<?php

namespace App\Infra\UseCase\Read;

interface IListUseCaseV2
{
    public function execute(int $perPage, int $page, string $search, string $orderBy, string $orderByDirection, array|null $queryParams = null): array;
}
