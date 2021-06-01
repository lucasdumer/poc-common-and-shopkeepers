<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'document' => ['required', 'max:14'],
            'email' => ['required', 'max:255'],
            'password' => ['required', 'max:255'],
            'balance' => ['required', 'numeric']
        ];
    }
}
