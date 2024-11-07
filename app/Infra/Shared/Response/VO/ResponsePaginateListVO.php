<?php

namespace App\Infra\Shared\Response\VO;

use App\Enums\Response\StatusCodeEnum;

class ResponsePaginateListVO implements IResponseListVO
{
    public function __construct(public array $data)
    {
    }

    public function toArray(): array
    {
        return [
            'status_code' => StatusCodeEnum::HttpOk->value,
            'links' => [
                'first' => $this->data['first_page_url'],
                'last' => $this->data['last_page_url'],
                'prev' => $this->data['prev_page_url'],
                'self' => $this->data['path'],
                'next' => $this->data['next_page_url'],
            ],
            'page' => [
                'from' => $this->data['from'],
                'to' => $this->data['to'],
                'total' => $this->data['total'],
                'per_page' => $this->data['per_page'],
                'current_page' => $this->data['current_page'],
            ],
            'data' => $this->data['data'],
        ];
    }
}
