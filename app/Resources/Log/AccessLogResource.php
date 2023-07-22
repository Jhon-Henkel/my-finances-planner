<?php

namespace App\Resources\Log;

use App\DTO\Log\AccessLogDTO;
use App\Resources\BasicResource;
use App\VO\Log\AccessLogVO;

class AccessLogResource extends BasicResource
{

    public function arrayToDto(array $item): AccessLogDTO
    {
        return new AccessLogDTO(
            $item['id'],
            $item['user_id'],
            $item['user_ip'],
            $item['account_group'],
            $item['user_agent'],
            $item['logged'],
            $item['comments'],
            $item['created_at'] ?? null,
        );
    }

    /**
     * @param AccessLogDTO $item
     * @return array
     */
    public function dtoToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'user_id' => $item->getUserId(),
            'user_ip' => $item->getUserIp(),
            'account_group' => $item->getAccountGroup(),
            'user_agent' => $item->getUserAgent(),
            'logged' => $item->getLogged(),
            'comments' => $item->getComments(),
            'created_at' => $item->getCreatedAt(),
        ];
    }

    /**
     * @param AccessLogDTO $item
     * @return AccessLogVO
     */
    public function dtoToVo($item): AccessLogVO
    {
        return new AccessLogVO($item);
    }
}