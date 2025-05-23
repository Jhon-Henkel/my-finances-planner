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

    public static function renderOk(array|null $data = null): JsonResponse
    {
        return response()->json($data, StatusCodeEnum::HttpOk->value);
    }

    public static function renderUnauthorized(): JsonResponse
    {
        return response()->json(null, StatusCodeEnum::HttpUnauthorized->value);
    }

    public static function renderInternalServerError(string $error): JsonResponse
    {
        return response()->json($error, StatusCodeEnum::HttpInternalServerError->value);
    }
}
