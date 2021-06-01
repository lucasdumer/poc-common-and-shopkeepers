<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function all($keys = null)
    {
        $data = parent::all();
        $data['id'] = $this->route('id');
        return $data;
    }

    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
            'name' => ['required', 'max:255'],
            'document' => ['required', 'max:14'],
            'email' => ['required', 'max:255'],
            'password' => ['required', 'max:255']
        ];
    }
}
