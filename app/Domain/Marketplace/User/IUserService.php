<?php

namespace App\Domain\Marketplace\User;

interface IUserService
{
    public function create(IUserCreateCommand $userCreateCommand): User;
    public function find(int $id): User;
    public function update(IUserUpdateCommand $userUpdateCommand): User;
    public function delete(int $id): bool;
    public function list(): array;
}
