<?php

namespace App\Infra\UseCase\Read;

/**
 * @deprecated - deletar ao não ter mais uso
 */
interface IListUseCase
{
    public function execute(int $perPage, int $page, array|null $queryParams = null): array;
}
