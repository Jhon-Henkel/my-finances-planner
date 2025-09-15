<?php

namespace App\Infra\Response\VO;

use App\Infra\Response\Enum\HttpStatusCodeEnum;

/**
 * @deprecated - deletar ao deletar o BaseListController
 */
class ResponsePaginateListVO implements IResponseVO
{
    public function __construct(public array $data)
    {
    }

    public function toArray(): array
    {
        return [
            'status_code' => HttpStatusCodeEnum::HttpOk->value,
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
            'meta' => $this->data['meta'] ?? [],
        ];
    }
}
