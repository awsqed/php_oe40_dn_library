<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:254|unique:users',
            'email' => 'required|string|email|max:254|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

}
