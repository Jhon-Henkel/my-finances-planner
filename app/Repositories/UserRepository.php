<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;
use App\Resources\UserResource;
use App\Services\Database\DatabaseConnectionService;

class UserRepository extends BasicRepository
{
    public function __construct(
        private readonly User $model,
        private readonly UserResource $resource
    ) {
    }

    protected function getModel(): User
    {
        return $this->model;
    }

    protected function getResource(): UserResource
    {
        return $this->resource;
    }

    public function update(int $id, $item)
    {
        $array = $this->getResource()->dtoToArray($item);
        $user = $this->getModel()->find($id);
        $user->fill($array);
        $user->save();
        return $item;
    }

    public function findByEmail(string $email)
    {
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();
        return $this->getModel()->where('email', $email)->first();
    }

    public function findByVerifyHash(string $verifyHash): null|UserDTO
    {
        $user = $this->getModel()->where('verify_hash', $verifyHash)->first();
        if (! $user) {
            return null;
        }
        return $this->getResource()->arrayToDto($user->toArray());
    }

    public function activeUser(int $id): void
    {
        $user = $this->getModel()->findOrFail($id);
        $user->status = 1;
        $user->verify_hash = '';
        $user->email_verified_at = now();
        $user->wrong_login_attempts = 0;
        $user->save();
    }
}
