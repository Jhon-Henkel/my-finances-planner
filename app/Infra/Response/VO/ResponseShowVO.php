<?php

namespace App\Infra\Response\VO;

use App\Infra\Response\Enum\HttpStatusCodeEnum;

/**
 * @deprecated - deletar ao deletar o BaseShowController
 */
class ResponseShowVO implements IResponseVO
{
    public function __construct(public array $data)
    {
    }

    public function toArray(): array
    {
        return [
            'status_code' => HttpStatusCodeEnum::HttpOk->value,
            'data' => $this->data
        ];
    }
}
