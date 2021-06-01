<?php

namespace App\Application\Commands;

use App\Domain\Marketplace\User\IUserCreateCommand;

class UserCreateCommand implements IUserCreateCommand
{
    public function __construct(
        private string $name,
        private string $document,
        private string $email,
        private string $password,
        private string $balance,
    ) {}

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

    public function getBalance(): float
    {
        return $this->balance;
    }
}
