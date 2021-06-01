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
        try {
            $userCreateCommand = new UserCreateCommand(
                $request->name,
                $request->document,
                $request->email,
                $request->password,
                $request->balance,
            );
            return $this->success($this->userService->create($userCreateCommand)->toArray());
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }

    public function find(FindRequest $request)
    {
        try {
            return $this->success($this->userService->find($request->id)->toArray());
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            $userUpdateCommand = new UserUpdateCommand(
                $request->id,
                $request->name,
                $request->document,
                $request->email,
                $request->password,
                $request->balance,
            );
            return $this->success($this->userService->update($userUpdateCommand)->toArray());
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }

    public function delete(DeleteRequest $request)
    {
        try {
            return $this->success($this->userService->delete($request->id));
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }

    public function list(UserListRequest $request)
    {
        try {
            return $this->success($this->userService->list());
        } catch(\Exception $e) {
            return $this->error($e);
        }
    }
}
