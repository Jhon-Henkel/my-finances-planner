<?php

namespace App\Infra\Controller\Read;

use App\Http\Controllers\Controller;
use App\Infra\Request\Enum\RequestQueryParamsEnum;
use App\Infra\Response\ApiResponseRender;
use App\Infra\Response\VO\ResponsePaginateListVO;
use App\Infra\UseCase\Read\IListUseCase;
use Illuminate\Http\JsonResponse;

/**
 * @deprecated use BaseListControllerV2
 */
abstract class BaseListController extends Controller
{
    private const int DEFAULT_PAGE = 1;
    private const int DEFAULT_PER_PAGE = 10000;

    abstract protected function getUseCase(): IListUseCase;

    public function __invoke(): JsonResponse
    {
        $list = $this->getUseCase()->execute($this->getPerPage(), $this->getPage(), $this->getQueryParams());
        $responseVO = new ResponsePaginateListVO($list);
        return ApiResponseRender::renderList($responseVO);
    }

    protected function getPerPage()
    {
        return request()->get(RequestQueryParamsEnum::PerPage->value, self::DEFAULT_PER_PAGE);
    }

    public function getPage()
    {
        return request()->get(RequestQueryParamsEnum::Page->value, self::DEFAULT_PAGE);
    }

    public function getQueryParams(): array
    {
        return request()->query();
    }
}
