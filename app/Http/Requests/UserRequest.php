<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        if ($this->routeIs('register')) {
            return true;
        } elseif ($this->routeIs('users.store')) {
            return Gate::allows('create-user');
        } elseif ($this->routeIs('users.update')) {
            return Gate::allows('update-user-info');
        }

        return false;
    }

    public function rules()
    {
        $rules = [
            'username' => 'required|string|min:8|max:254|unique:users',
            'email' => 'required|string|email|max:254|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($this->routeIs('users.store', 'users.update')) {
            $rules['password'] = 'nullable|string|min:8';
            $rules = array_merge($rules, [
                'image' => 'nullable|image|dimensions:ratio=1|max:2048',
                'first_name' => 'nullable|string|max:254',
                'last_name' => 'nullable|string|max:254',
                'gender' => 'boolean',
                'birthday' => 'nullable|date|before:now',
                'phone' => 'nullable|string|max:254',
                'address' => 'nullable|string|max:254',
            ]);

            if ($this->routeIs('users.update')) {
                $rules['username'] = [
                    'required',
                    'string',
                    'min:8',
                    'max:254',
                    Rule::unique('users')->ignore($this->user),
                ];
                $rules['email'] = [
                    'required',
                    'string',
                    'email',
                    'max:254',
                    Rule::unique('users')->ignore($this->user),
                ];
            }
        }

        return $rules;
    }

}
