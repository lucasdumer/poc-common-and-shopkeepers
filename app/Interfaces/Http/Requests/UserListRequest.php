<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserListRequest extends FormRequest
{
    public function all($keys = null)
    {
        $data = parent::all();
        $data['name'] = $this->query('name');
        return $data;
    }

    public function rules()
    {
        return [];
    }
}
