<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService extends BasicService
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): UserRepository
    {
        return $this->repository;
    }

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
        if (! empty($item->getSalary())) {
            $itemDb->setSalary($item->getSalary());
        }
        if (! empty($item->getPassword())) {
            $password = $item->getPassword();
            $itemDb->setPassword(bcrypt($password));
        }
        return parent::update($id, $itemDb);
    }

    public function findUserByEmail(string $email): null|User
    {
        return $this->getRepository()->findByEmail($email);
    }
}