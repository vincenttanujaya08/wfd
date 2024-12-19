<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ensure only authenticated users can make this request
    }

    public function rules()
    {
        return [
            'text' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'The comment text is required.',
        ];
    }
}
