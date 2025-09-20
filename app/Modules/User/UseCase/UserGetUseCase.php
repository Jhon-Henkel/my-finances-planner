<?php

namespace App\Modules\User\UseCase;

use App\Repositories\UserRepository;

class UserGetUseCase
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function execute(int $id): array
    {
        $user = $this->repository->findById($id);
        return $user->toArray();
    }
}
