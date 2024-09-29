<?php

namespace App\DTO\User;

use App\Tools\Calendar\CalendarTools;

class UserRegisterDatabaseCreationDTO
{
    private string $dbName;
    private readonly string $dbPass;
    private readonly string $dbUser;

    public function __construct(UserRegisterDTO $userRegister)
    {
        $timestamp = CalendarTools::getDateNow()->getTimestamp();
        $this->dbName = md5("{$userRegister->getEmail()}$timestamp" . rand(1000, 9999));
        $this->dbPass = md5("{$userRegister->getEmail()}$timestamp" . rand(1000, 9999));
        $this->dbUser = md5("{$userRegister->getEmail()}$timestamp" . rand(1000, 9999));
    }

    public function updateDbNameAfterDbCreation(string $newName): void
    {
        $this->dbName = $newName;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function getDbPass(): string
    {
        return $this->dbPass;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }
}
