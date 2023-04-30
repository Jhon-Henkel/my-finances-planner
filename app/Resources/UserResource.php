<?php

namespace App\Resources;

use App\DTO\UserDTO;
use App\Enums\BasicFieldsEnum;
use App\VO\UserVO;

class UserResource extends BasicResource
{
    public function arrayToDto(array $item): UserDTO
    {
        $user = new UserDTO();
        $user->setId($item[BasicFieldsEnum::ID] ?? null);
        $user->setName($item[BasicFieldsEnum::NAME]);
        $user->setEmail($item[BasicFieldsEnum::EMAIL]);
        $user->setPassword($item[BasicFieldsEnum::PASSWORD] ?? null);
        $user->setSalary($item[BasicFieldsEnum::SALARY]);
        $user->setStatus($item[BasicFieldsEnum::STATUS] ?? null);
        $user->setEmailVerifiedAt($item[BasicFieldsEnum::EMAIL_VERIFIED_AT] ?? null);
        $user->setCreatedAt($item[BasicFieldsEnum::CREATED_AT] ?? null);
        $user->setUpdatedAt($item[BasicFieldsEnum::UPDATED_AT] ?? null);
        return $user;
    }

    /**
     * @param $item
     * @return UserDTO[]
     */
    public function dtoToArray($item): array
    {
        return [
            BasicFieldsEnum::ID => $item->getId(),
            BasicFieldsEnum::NAME => $item->getName(),
            BasicFieldsEnum::EMAIL => $item->getEmail(),
            BasicFieldsEnum::PASSWORD => $item->getPassword(),
            BasicFieldsEnum::SALARY => $item->getSalary(),
            BasicFieldsEnum::STATUS => $item->getStatus(),
            BasicFieldsEnum::EMAIL_VERIFIED_AT => $item->getEmailVerifiedAt(),
            BasicFieldsEnum::CREATED_AT => $item->getCreatedAt(),
            BasicFieldsEnum::UPDATED_AT => $item->getUpdatedAt(),
        ];

    }

    /**
     * @param UserDTO $item
     * @return UserVO
     */
    public function dtoToVo($item): UserVO
    {
        return UserVO::make($item);
    }
}