<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ensure only authenticated users can make this request
    }

    public function rules()
    {
        return [
            'description' => 'required|string|max:1000',
            'topic' => 'nullable|string|max:255', // Single string for topic input
            'image_links' => 'required|array|min:1|max:5', // Must be an array with 1-5 links
            'image_links.*' => 'required|url', // Each link must be a valid URL
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'The caption is required.',
            'image_links.required' => 'At least one image link is required.',
            'image_links.*.url' => 'Each image link must be a valid URL.',
        ];
    }
}
