<?php

namespace App\Repositories;

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
}