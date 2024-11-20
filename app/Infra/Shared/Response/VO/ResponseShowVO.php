<?php

namespace App\Infra\Shared\Response\VO;

use App\Enums\Response\StatusCodeEnum;

class ResponseShowVO implements IResponseVO
{
    public function __construct(public array $data)
    {
    }

    public function toArray(): array
    {
        return [
            'status_code' => StatusCodeEnum::HttpOk->value,
            'data' => $this->data
        ];
    }
}
