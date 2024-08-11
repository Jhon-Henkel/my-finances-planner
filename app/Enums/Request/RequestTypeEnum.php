<?php

namespace App\Enums\Request;

enum RequestTypeEnum: string
{
    case Post = 'POST';
    case Get = 'GET';
    case Put = 'PUT';
    case Delete = 'DELETE';
}
