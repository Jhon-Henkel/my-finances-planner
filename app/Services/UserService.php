<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Auth\AuthService;
use App\Tools\AppTools;
use App\Tools\Auth\JwtTools;
use Illuminate\Database\Eloquent\Model;

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
        if (! empty($item->getMarketPlannerValue())) {
            $itemDb->setMarketPlannerValue($item->getMarketPlannerValue());
        }
        return parent::update($id, $itemDb);
    }

    public function findUserByEmail(string $email): Model|null
    {
        return $this->getRepository()->findByEmail($email);
    }

    public function findByVerifyHash(string $verifyHash): null|UserDTO
    {
        return $this->getRepository()->findByVerifyHash($verifyHash);
    }

    public function activeUser(int $id): bool
    {
        return $this->getRepository()->activeUser($id);
    }

    /** @codeCoverageIgnore */
    public function developGetTokens(): array
    {
        return [
            'MFP-TOKEN' => AppTools::getEnvValue('PUSHER_APP_KEY'),
            'X-MFP-USER-TOKEN' => JwtTools::createJWT(
                app(AuthService::class)->findUserForAuth('demo@demo.dev')
            )
        ];
    }
}
