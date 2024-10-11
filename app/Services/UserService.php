<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Enums\Cache\CacheKeyEnum;
use App\Exceptions\User\InvalidCurrentPasswordException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Auth\AuthService;
use App\Tools\Auth\JwtTools;
use App\Tools\Cache\MfpCacheManager;

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
        MfpCacheManager::delete($itemDb->getEmail(), CacheKeyEnum::User);
        return parent::update($id, $itemDb);
    }

    public function findUserByEmail(string $email): User|null
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
            'MFP-TOKEN' => config('app.mfp_token'),
            'X-MFP-USER-TOKEN' => JwtTools::createJWT(
                app(AuthService::class)->findUserForAuth('demo@demo.dev')
            )
        ];
    }
}
