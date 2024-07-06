<?php

namespace App\DTO;

class UserDTO
{
    private int $id;
    private string $name;
    private string $email;
    private null|string $password;
    private string $unique_id;
    private null|int $status;
    private float $salary;
    private float $marketPlannerValue;
    private string $verifyHash = '';
    private mixed $created_at;
    private mixed $updated_at;
    private mixed $emailVerifiedAt;
    private int $wrongLoginAttempts = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): null|string
    {
        return $this->password;
    }

    public function setPassword(null|string $password): void
    {
        $this->password = $password;
    }

    public function getUniqueId(): string
    {
        return $this->unique_id;
    }

    public function setUniqueId(string $unique_id): void
    {
        $this->unique_id = $unique_id;
    }

    public function getStatus(): null|int
    {
        return $this->status;
    }

    public function setStatus(null|int $status): void
    {
        $this->status = $status;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): void
    {
        $this->salary = $salary;
    }

    public function getMarketPlannerValue(): float
    {
        return $this->marketPlannerValue;
    }

    public function setMarketPlannerValue(float $marketPlannerValue): void
    {
        $this->marketPlannerValue = $marketPlannerValue;
    }

    public function getVerifyHash(): string
    {
        return $this->verifyHash;
    }

    public function setVerifyHash(string $verifyHash): void
    {
        $this->verifyHash = $verifyHash;
    }

    public function getCreatedAt(): mixed
    {
        return $this->created_at;
    }

    public function setCreatedAt(mixed $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): mixed
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(mixed $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getEmailVerifiedAt(): mixed
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(mixed $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function getWrongLoginAttempts(): int
    {
        return $this->wrongLoginAttempts;
    }

    public function setWrongLoginAttempts(int $wrongLoginAttempts): void
    {
        $this->wrongLoginAttempts = $wrongLoginAttempts;
    }
}
