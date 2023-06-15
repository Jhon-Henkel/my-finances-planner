<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Enums\BasicFieldsEnum;
use App\Models\User;
use App\Resources\UserResource;

class UserRepository extends BasicRepository
{
    protected User $model;
    protected UserResource $resource;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->resource = app(UserResource::class);
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
        $this->getModel()->where(BasicFieldsEnum::ID, $id)->update($array);
        return $item;
    }

    public function findByEmail(string $email): null|User
    {
        return $this->getModel()->where(BasicFieldsEnum::EMAIL, $email)->first();
    }

    public function findByVerifyHash(string $verifyHash): null|UserDTO
    {
        $user = $this->getModel()->where('verify_hash', $verifyHash)->first();
        if (! $user) {
            return null;
        }
        return $this->getResource()->arrayToDto($user->toArray());
    }

    public function activeUser(int $id): bool
    {
        return $this->getModel()->where(BasicFieldsEnum::ID, $id)
            ->update(['status' => 1, 'verify_hash' => '', 'email_verified_at' => now(), 'wrong_login_attempts' => 0]);
    }
}