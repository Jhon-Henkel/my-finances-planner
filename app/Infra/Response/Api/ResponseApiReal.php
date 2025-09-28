<?php

namespace App\Infra\Response\Api;

use App\Infra\Response\Enum\HttpStatusCodeEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class ResponseApiReal
{
    public function renderCreated(array|null $data = null): JsonResponse
    {
        return $this->responseJson($data, HttpStatusCodeEnum::HttpCreated);
    }

    public function renderOk(array|null $data = null): JsonResponse
    {
        return $this->responseJson($data, HttpStatusCodeEnum::HttpOk);
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

    public function renderNoContent(): JsonResponse
    {
        return $this->responseJson(null, HttpStatusCodeEnum::HttpNoContent);
    }

    public function renderUnauthorized(string|null $data = null): JsonResponse
    {
        return $this->responseJson($data, HttpStatusCodeEnum::HttpUnauthorized);
    }

    public function renderNotFount(): JsonResponse
    {
        return $this->responseJson(Lang::get('object_not_found'), HttpStatusCodeEnum::HttpNotFound);
    }

    public function renderForbidden(string $message): JsonResponse
    {
        return $this->responseJson($message, HttpStatusCodeEnum::HttpForbidden);
    }

    public function renderBadRequest(string|array|null $data = null): JsonResponse
    {
        return $this->responseJson($data, HttpStatusCodeEnum::HttpBadRequest);
    }

    public function renderTooManyRequests(string $message): JsonResponse
    {
        return $this->responseJson($message, HttpStatusCodeEnum::HttpTooManyRequests);
    }

    public function renderInternalServerError(string $error): JsonResponse
    {
        return $this->responseJson($error, HttpStatusCodeEnum::HttpInternalServerError);
    }

    protected function responseJson(mixed $data, HttpStatusCodeEnum $statusCode): JsonResponse
    {
        return response()->json($this->makeData($data, $statusCode), $statusCode->value);
    }

    protected function makeData(mixed $data, HttpStatusCodeEnum $statusCode): array
    {
        return [
            'status' => $statusCode->value,
            'data' => $data,
        ];
    }
}
