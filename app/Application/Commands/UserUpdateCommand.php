<?php

namespace App\Application\Commands;

use App\Domain\Marketplace\User\IUserUpdateCommand;

class UserUpdateCommand implements IUserUpdateCommand
{
    public function __construct(
        private int $id,
        private string $name,
        private string $document,
        private string $email,
        private string $password,
        private string $balance,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }
}
