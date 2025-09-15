<?php

namespace App\Infra\Controller\Read;

use App\Http\Controllers\Controller;
use App\Infra\UseCase\Read\IListUseCaseV2;
use App\Tools\Response\ResponseApi;
use Illuminate\Http\JsonResponse;

abstract class BaseListControllerV2 extends Controller
{
    protected const int DEFAULT_PAGE = 1;
    protected const int DEFAULT_PER_PAGE = 10000;
    protected const string DEFAULT_SEARCH = '';
    protected const string DEFAULT_ORDER_BY = 'id';
    protected const string DEFAULT_ORDER_BY_DIRECTION = 'desc';

    abstract protected function getUseCase(): IListUseCaseV2;

    public function __invoke(): JsonResponse
    {
        $list = $this->getUseCase()->execute(
            $this->getPerPage(),
            $this->getPage(),
            $this->getSearch(),
            $this->getOrderBy(),
            $this->getOrderDirection(),
            $this->getQueryParams()
        );
        return ResponseApi::renderOkList($list);
    }

    protected function getPerPage(): int
    {
        return request()->get('per_page') ?? self::DEFAULT_PER_PAGE;
    }

    public function getPage(): int
    {
        return request()->get('page') ?? self::DEFAULT_PAGE;
    }

    public function getSearch(): string
    {
        return request()->get('search') ?? self::DEFAULT_SEARCH;
    }

    public function getOrderBy(): string
    {
        return request()->get('order_by') ?? self::DEFAULT_ORDER_BY;
    }

    public function getOrderDirection(): string
    {
        return request()->get('order_direction') ?? self::DEFAULT_ORDER_BY_DIRECTION;
    }

    public function getQueryParams(): array
    {
        return request()->query();
    }
}
