<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class PublisherRequest extends FormRequest
{

    public function authorize()
    {
        if ($this->routeIs('publishers.store')) {
            return Gate::allows('create-publisher');
        } elseif ($this->routeIs('publishers.update')) {
            return Gate::allows('update-publisher');
        }

        return false;
    }

    public function rules()
    {
        return [
            'image' => 'nullable|image|dimensions:ratio=1|max:1024',
            'name' => 'required|string|max:254',
            'description' => 'nullable|max:254',
        ];
    }

}
