<?php

namespace App\VO;

use App\DTO\UserDTO;

class UserVO
{
    public string $name;
    public string $email;
    public int $status;

    public static function make(UserDTO $user): self
    {
        $vo = new self();
        $vo->name = $user->getName();
        $vo->email = $user->getEmail();
        $vo->status = $user->getStatus();
        return $vo;
    }
}
