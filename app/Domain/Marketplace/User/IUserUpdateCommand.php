<?php

namespace App\Domain\Marketplace\User;

interface IUserUpdateCommand extends IUserCreateCommand
{
    public function getId(): int;
}
