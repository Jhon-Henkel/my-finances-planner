<?php

namespace App\Modules\User\UseCase;

use App\DTO\UserDTO;
use App\Services\UserService;

class UserUpdateUseCase
{
    public function __construct(private readonly UserService $service)
    {
    }

    public function execute(int $id, array $data): array
    {
        $userDto = new UserDTO($data);
        $user = $this->service->update($id, $userDto);
        return $user->toArray();
    }
}
