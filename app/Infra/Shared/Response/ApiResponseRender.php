<?php

namespace App\Infra\Shared\Response;

use App\Infra\Shared\Response\VO\IResponseListVO;
use Illuminate\Http\JsonResponse;

class ApiResponseRender
{
    public static function renderList(IResponseListVO $data): JsonResponse
    {
        return response()->json($data->toArray());
    }
}
