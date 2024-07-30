<?php

namespace App\Resources;

use App\DTO\UserDTO;
use App\VO\UserVO;

class UserResource extends BasicResource
{
    public function arrayToDto(array $item): UserDTO
    {
        $user = new UserDTO();
        $user->setId($item['id'] ?? null);
        $user->setName($item['name']);
        $user->setEmail($item['email']);
        $user->setPassword($item['password'] ?? null);
        $user->setMarketPlannerValue($item['market_planner_value'] ?? $item['marketPlannerValue']);
        $user->setStatus($item['status'] ?? null);
        $user->setEmailVerifiedAt($item['email_verified_at'] ?? null);
        $user->setVerifyHash($item['verify_hash' ] ?? '');
        $user->setWrongLoginAttempts($item['wrong_login_attempts'] ?? 0);
        $user->setCreatedAt($item['created_at'] ?? null);
        $user->setUpdatedAt($item['updated_at'] ?? null);
        return $user;
    }

    /** @param UserDTO $item */
    public function dtoToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'email' => $item->getEmail(),
            'password' => $item->getPassword(),
            'market_planner_value' => $item->getMarketPlannerValue(),
            'status' => $item->getStatus(),
            'verify_hash' => $item->getVerifyHash(),
            'wrong_login_attempts' => (int)$item->getWrongLoginAttempts(),
            'email_verified_at' => $item->getEmailVerifiedAt(),
            'created_at' => $item->getCreatedAt(),
            'updated_at' => $item->getUpdatedAt(),
        ];
    }

    /** @param UserDTO $item */
    public function dtoToVo($item): UserVO
    {
        return UserVO::make($item);
    }
}
