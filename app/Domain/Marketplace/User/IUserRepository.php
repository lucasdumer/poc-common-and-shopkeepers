<?php

namespace App\Domain\Marketplace\User;

interface IUserRepository
{
    public function create(User $user): User;
    public function find(int $id): User;
    public function update(User $user): User;
    public function delete(int $id): bool;
    public function list(): array;
}
