<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_active' => ['boolean'],
            'name' => ['required'],
            'slug' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
