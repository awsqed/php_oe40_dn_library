<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize()
    {
        if ($this->routeIs('categories.store')) {
            return Gate::allows('create-category');
        } elseif ($this->routeIs('categories.update')) {
            return Gate::allows('update-category');
        }

        return false;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:254',
            'description' => 'nullable|max:254',
        ];

        if (!empty($this->parent)) {
            $rules['parent'] = 'exists:categories,id';
        }

        return $rules;
    }

}
