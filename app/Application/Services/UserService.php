<?php

namespace App\Application\Services;

use App\Domain\Marketplace\User\Document;
use App\Domain\Marketplace\User\IUserCreateCommand;
use App\Domain\Marketplace\User\IUserService;
use App\Domain\Marketplace\User\IUserUpdateCommand;
use App\Domain\Marketplace\User\User;
use App\Infrastructure\Repositories\UserRepository;

class UserService implements IUserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function create(IUserCreateCommand $userCreateCommand): User
    {
        try {
            $user = new User(
                $userCreateCommand->getName(),
                new Document($userCreateCommand->getDocument()),
                $userCreateCommand->getEmail(),
                $userCreateCommand->getPassword(),
                $userCreateCommand->getBalance(),
            );
            return $this->userRepository->create($user);
        } catch(\Exception $e) {
            throw new \Exception("Service error on creating user. ".$e->getMessage());
        }

    }

    public function find(int $id): User
    {
        try {
            return $this->userRepository->find($id);
        } catch(\Exception $e) {
            throw new \Exception("Service error on find user. ".$e->getMessage());
        }
    }

    public function update(IUserUpdateCommand $userUpdateCommand): User
    {
        try {
            $user = $this->find($userUpdateCommand->getId());
            $user->update(
                $userUpdateCommand->getName(),
                new Document($userUpdateCommand->getDocument()),
                $userUpdateCommand->getEmail(),
                $userUpdateCommand->getPassword()
            );
            return $this->userRepository->update($user);
        } catch(\Exception $e) {
            throw new \Exception("Service error on update user. ".$e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->userRepository->delete($id);
        } catch(\Exception $e) {
            throw new \Exception("Service error on delete user. ".$e->getMessage());
        }
    }

    public function list(): array
    {
        try {
            return $this->userRepository->list();
        } catch(\Exception $e) {
            throw new \Exception("Service error on list user. ".$e->getMessage());
        }
    }
}
