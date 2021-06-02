<?php

namespace App\Domain\Marketplace\User;

class User
{
    private int $id;

    public function __construct(
        private string $name,
        private Document $document,
        private string $email,
        private string $password,
        private float $balance
    ) {
        $this->validate();
    }

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
        $this->validate();
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
        $this->validate();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
        $this->validate();
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function addBalance(float $balance): void
    {
        $this->balance += $balance;
        $this->validate();
    }

    public function removeBalance(float $balance): void
    {
        $this->balance -= $balance;
        $this->validate();
    }

    public function update(
        string $name,
        Document $document,
        string $email,
        string $password
    ) {
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
        $this->password = $password;
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->name)) {
            throw new \Exception("Invalid name.");
        }

        if (empty($this->email)) {
            throw new \Exception("Invalid e-mail.");
        }

        if (empty($this->password)) {
            throw new \Exception("Invalid password.");
        }

        if ($this->balance < 0) {
            throw new \Exception("Balance less than zero.");
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'document' => $this->document->getValue(),
            'email' => $this->email,
            'balance' => $this->balance
        ];
    }

    public function validateSingleDocument(array $users): void
    {
        foreach ($users as $user) {
            if (
                (empty($this->id) && $this->document->getValue() == $user->getDocument()->getValue()) ||
                (
                    !empty($this->id) &&
                    $this->id != $user->getId() &&
                    $this->document->getValue() == $user->getDocument()->getValue()
                )
            ) {
                throw new \Exception("This document already exists.");
            }
        }
    }

    public function validateSingleEmail(array $users): void
    {
        foreach ($users as $user) {
            if (
                (empty($this->id) && $this->email == $user->getEmail()) ||
                (
                    !empty($this->id) &&
                    $this->id != $user->getId() &&
                    $this->email == $user->email
                )
            ) {
                throw new \Exception("This email already exists.");
            }
        }
    }

    public function isAShopkeeper(): bool
    {
        return $this->document->itsAShopkeepersDocument();
    }
}
