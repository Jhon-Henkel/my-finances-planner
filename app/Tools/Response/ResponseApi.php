<?php

namespace App\Tools\Response;

use App\Infra\Response\Enum\HttpStatusCodeEnum;
use Illuminate\Http\JsonResponse;

/**
 * @deprecated
 */
class ResponseApi
{
    public static function renderCreated(): JsonResponse
    {
        return response()->json(null, HttpStatusCodeEnum::HttpCreated->value);
    }

    public static function renderOk(array|null $data = null): JsonResponse
    {
        return response()->json($data, HttpStatusCodeEnum::HttpOk->value);
    }

    public static function renderUnauthorized(): JsonResponse
    {
        return response()->json(null, HttpStatusCodeEnum::HttpUnauthorized->value);
    }

    public static function renderInternalServerError(string $error): JsonResponse
    {
        return response()->json($error, HttpStatusCodeEnum::HttpInternalServerError->value);
    }

    public function renderOkList(array|null $data = null): JsonResponse
    {
        if (is_array($data)) {
            if (!array_key_exists('data', $data)) {
                $data = [ 'data' => $data ];
            }
            $data['status'] = HttpStatusCodeEnum::HttpOk->value;
        }
        return response()->json($data, HttpStatusCodeEnum::HttpOk->value);
    }
}
