<?php

namespace App\Tools\Response;

use App\Enums\Response\StatusCodeEnum;
use Illuminate\Http\JsonResponse;

class ResponseApi
{
    public static function renderCreated(): JsonResponse
    {
        return response()->json(null, StatusCodeEnum::HttpCreated->value);
    }

    public static function renderOk(): JsonResponse
    {
        return response()->json(null, StatusCodeEnum::HttpOk->value);
    }
}
