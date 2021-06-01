<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Marketplace\User\Document;
use App\Domain\Marketplace\User\IUserRepository;
use App\Domain\Marketplace\User\User;
use App\Infrastructure\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function create(User $user): User
    {
        try {
            $userModel = new UserModel();
            $userModel->name = $user->getName();
            $userModel->document = $user->getDocument()->getValue();
            $userModel->email = $user->getEmail();
            $userModel->password = Hash::make($user->getPassword());
            $userModel->balance = $user->getBalance();
            $userModel->save();
            $user->setId($userModel->id);
            return $user;
        } catch(\Exception $e) {
            throw new \Exception("Database error on create user. ".$e->getMessage());
        }
    }

    public function find(int $id): User
    {
        try {
            $userModel = UserModel::find($id);
            if (!$userModel) {
                throw new \Exception("Dont find user with id: ".$id);
            }
            $user = new User(
                $userModel->name,
                new Document($userModel->document),
                $userModel->email,
                $userModel->password,
                $userModel->balance,
            );
            $user->setId($userModel->id);
            return $user;
        } catch(\Exception $e) {
            throw new \Exception("Database error on find user. ".$e->getMessage());
        }
    }

    public function update(User $user): User
    {
        try {
            UserModel::where('id', $user->getId())
                ->update([
                    'name' => $user->getName(),
                    'document' => $user->getDocument()->getValue(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getPassword()),
                    'balance' => $user->getBalance()
                ]);
            return $user;
        } catch(\Exception $e) {
            throw new \Exception("Database error on update user. ".$e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            UserModel::where('id', $id)->delete();
            return true;
        } catch(\Exception $e) {
            throw new \Exception("Database error on delete user. ".$e->getMessage());
        }
    }

    private function get(
        string $name = null,
        string $document = null,
        string $email = null
    ): array {
        $table = DB::table('users');
        if (!empty($name)) {
            $table->where('name', '=', $name);
        }
        if (!empty($document)) {
            $table->where('document', '=', $document);
        }
        if (!empty($email)) {
            $table->where('email', '=', $email);
        }
        return $table->get()->toArray();
    }

    public function list(
        string $name = null,
        string $document = null,
        string $email = null
    ): array {
        try {
            return $this->toArray($this->get($name, $document, $email));
        } catch(\Exception $e) {
            throw new \Exception("Database error on list user. ".$e->getMessage());
        }
    }

    public function load(
        string $name = null,
        string $document = null,
        string $email = null
    ): array {
        try {
            return $this->toArrayObj($this->get($name, $document, $email));
        } catch(\Exception $e) {
            throw new \Exception("Database error on load user. ".$e->getMessage());
        }
    }

    private function toArray($users)
    {
        return array_map(function ($userModel) {
            return [
                'id' => $userModel->id,
                'name' => $userModel->name,
                'document' => $userModel->document,
                'email' => $userModel->email,
                'balance' => $userModel->balance
            ];
        }, $users);
    }

    private function toArrayObj($users)
    {
        return array_map(function ($userModel) {
            $user = new User(
                $userModel->name,
                new Document($userModel->document),
                $userModel->email,
                $userModel->password,
                $userModel->balance
            );
            $user->setId($userModel->id);
            return $user;
        }, $users);
    }
}
