<?php

namespace App\Domain\Marketplace\User;

interface IUserUpdateCommand
{
    public function getId(): int;
    public function getName(): string;
    public function getDocument(): string;
    public function getEmail(): string;
    public function getPassword(): string;
}
