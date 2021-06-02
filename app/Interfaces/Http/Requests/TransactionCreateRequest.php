<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'payerId' => ['required', 'integer'],
            'payeeId' => ['required', 'integer'],
            'value' => ['required', 'numeric']
        ];
    }
}
