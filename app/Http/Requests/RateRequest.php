<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rating' => 'required|numeric|between:1,5',
            'comment' => 'nullable|string|max:1024',
        ];
    }

}
