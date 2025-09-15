<?php

namespace App\Infra\Request\Enum;

/**
 * @deprecated - deletar ao deletar o BaseListController
 */
enum RequestQueryParamsEnum: string
{
    case PerPage = 'per_page';
    case Page = 'page';
}
