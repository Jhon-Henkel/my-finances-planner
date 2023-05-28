<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class ResponseError
{
    public static function responseError(string $error, int $statusCode): JsonResponse
    {
        $message = json_decode($error, true);
        return response()->json(['message' => $message], $statusCode);
    }
}