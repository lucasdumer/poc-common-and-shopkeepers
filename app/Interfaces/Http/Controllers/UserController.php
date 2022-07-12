<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Commands\UserCreateCommand;
use App\Application\Commands\UserUpdateCommand;
use App\Application\Services\UserService;
use App\Interfaces\Http\Requests\DeleteRequest;
use App\Interfaces\Http\Requests\FindRequest;
use App\Interfaces\Http\Requests\UserCreateRequest;
use App\Interfaces\Http\Requests\UserListRequest;
use App\Interfaces\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function create(UserCreateRequest $request)
    {
        $userCreateCommand = new UserCreateCommand(
            $request->name,
            $request->document,
            $request->email,
            $request->password,
            $request->balance,
        );
        return $this->success($this->userService->create($userCreateCommand)->toArray());
    }

    public function find(FindRequest $request)
    {
        return $this->success($this->userService->find($request->id)->toArray());
    }

    public function update(UserUpdateRequest $request)
    {
        $userUpdateCommand = new UserUpdateCommand(
            $request->id,
            $request->name,
            $request->document,
            $request->email,
            $request->password
        );
        return $this->success($this->userService->update($userUpdateCommand)->toArray());
    }

    public function delete(DeleteRequest $request)
    {
        return $this->success($this->userService->delete($request->id));
    }

    public function list(UserListRequest $request)
    {
        return $this->success($this->userService->list());
    }
}
