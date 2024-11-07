<?php

namespace App\Infra\Shared\Request\Enum;

enum RequestQueryParamsEnum: string
{
    case PerPage = 'per_page';
    case Page = 'page';
}
