<?php

namespace App\Infra\Response;

use App\Infra\Response\VO\IResponseVO;
use Illuminate\Http\JsonResponse;

/**
 * @deprecated - deletar ao não ter mais uso
 */
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
