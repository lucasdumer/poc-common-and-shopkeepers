<?php

namespace App\Domain\Marketplace\User;

interface IUserCreateCommand
{
    public function getName(): string;
    public function getDocument(): string;
    public function getEmail(): string;
    public function getPassword(): string;
    public function getBalance(): double;
}
