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
    private string $verifyHash = '';
    private mixed $created_at;
    private mixed $updated_at;
    private mixed $emailVerifiedAt;
    private int $wrongLoginAttempts = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getPassword(): null|string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     */
    public function setPassword(null|string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->unique_id;
    }

    /**
     * @param string $unique_id
     */
    public function setUniqueId(string $unique_id): void
    {
        $this->unique_id = $unique_id;
    }

    /**
     * @return null|int
     */
    public function getStatus(): null|int
    {
        return $this->status;
    }

    /**
     * @param null|int $status
     */
    public function setStatus(null|int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return float
     */
    public function getSalary(): float
    {
        return $this->salary;
    }

    /**
     * @param float $salary
     */
    public function setSalary(float $salary): void
    {
        $this->salary = $salary;
    }

    /**
     * @return string
     */
    public function getVerifyHash(): string
    {
        return $this->verifyHash;
    }

    /**
     * @param string $verifyHash
     */
    public function setVerifyHash(string $verifyHash): void
    {
        $this->verifyHash = $verifyHash;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): mixed
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt(mixed $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): mixed
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt(mixed $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getEmailVerifiedAt(): mixed
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param mixed $emailVerifiedAt
     */
    public function setEmailVerifiedAt(mixed $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    /**
     * @return int
     */
    public function getWrongLoginAttempts(): int
    {
        return $this->wrongLoginAttempts;
    }

    /**
     * @param int $wrongLoginAttempts
     */
    public function setWrongLoginAttempts(int $wrongLoginAttempts): void
    {
        $this->wrongLoginAttempts = $wrongLoginAttempts;
    }
}