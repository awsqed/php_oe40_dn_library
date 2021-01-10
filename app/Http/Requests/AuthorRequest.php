<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{

    public function authorize()
    {
        if ($this->routeIs('authors.store')) {
            return Gate::allows('create-author');
        } elseif ($this->routeIs('authors.update')) {
            return Gate::allows('update-author');
        }

        return false;
    }

    public function rules()
    {
        return [
            'image' => 'nullable|image|dimensions:ratio=1|max:1024',
            'first_name' => 'nullable|string|max:254',
            'last_name' => 'nullable|string|max:254',
            'gender' => 'boolean',
            'birthday' => 'nullable|date|before:now',
        ];
    }

}
