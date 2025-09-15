<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Exceptions\User\InvalidCurrentPasswordException;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService extends BasicService
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    protected function getRepository(): UserRepository
    {
        return $this->repository;
    }

    /** @param UserDTO $item */
    public function update(int $id, $item)
    {
        $itemDb = $this->findById($id);
        if (! empty($item->getName())) {
            $itemDb->setName($item->getName());
        }
        if (! empty($item->getEmail())) {
            $itemDb->setEmail($item->getEmail());
        }
        if (! empty($item->getStatus())) {
            $itemDb->setStatus($item->getStatus());
        }
        if (! empty($item->getPassword())) {
            InvalidCurrentPasswordException::throwIfPasswordDontMatch($item, $itemDb);
            $itemDb->setPassword(bcrypt($item->getPassword()));
        }
        return parent::update($id, $itemDb);
    }

    public function findUserByEmail(string $email): User|null
    {
        return $this->getRepository()->findByEmail($email);
    }
}
