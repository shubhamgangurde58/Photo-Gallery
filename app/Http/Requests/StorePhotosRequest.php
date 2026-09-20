<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photos'   => ['required', 'array', 'min:1', 'max:20'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'], 
        ];
    }

    public function messages(): array
    {
        return [
            'photos.required' => 'Please choose at least one photo.',
            'photos.*.image'  => 'Each file must be an image.',
            'photos.*.max'    => 'Each photo must be 5 MB or smaller.',
        ];
    }
}