<?php

namespace App\Infra\Shared\Response;

use App\Infra\Shared\Response\VO\IResponseVO;
use Illuminate\Http\JsonResponse;

class ApiResponseRender
{
    public static function renderList(IResponseVO $data): JsonResponse
    {
        return response()->json($data->toArray());
    }

    public static function renderItem(IResponseVO $data): JsonResponse
    {
        return response()->json($data->toArray());
    }
}
