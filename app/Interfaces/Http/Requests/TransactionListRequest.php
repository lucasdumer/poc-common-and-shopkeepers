<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionListRequest extends FormRequest
{
    public function all($keys = null)
    {
        $data = parent::all();
        $data['payerId'] = $this->query('payerId');
        $data['payeeId'] = $this->query('payeeId');
        return $data;
    }

    public function rules()
    {
        return [];
    }
}
