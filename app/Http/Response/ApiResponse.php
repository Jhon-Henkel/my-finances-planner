<?php

namespace App\Http\Response;

use App\Infra\Response\Enum\HttpStatusCodeEnum;
use Illuminate\Http\JsonResponse;

/**
 * @deprecated
 */
class ApiResponse
{
    public static function responseError(string $error, int $statusCode): JsonResponse
    {
        $message = json_decode($error, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = $error;
        }
        return response()->json(['message' => $message], $statusCode);
    }

    public static function renderUnauthorized(string|null $data = null): JsonResponse
    {
        return self::responseJson($data, HttpStatusCodeEnum::HttpUnauthorized);
    }

    protected static function responseJson(mixed $data, HttpStatusCodeEnum $statusCode): JsonResponse
    {
        return response()->json(self::makeData($data, $statusCode), $statusCode->value);
    }

    protected static function makeData(mixed $data, HttpStatusCodeEnum $statusCode): array
    {
        return [
            'status' => $statusCode->value,
            'data' => $data,
        ];
    }
}
