<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'integer'],
            'type' => ['required'],
            'name' => ['required'],
            'full_name' => ['nullable'],
            'inn' => ['nullable'],
            'kpp' => ['nullable'],
            'ogrn' => ['nullable'],
            'address' => ['nullable'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email', 'max:254'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
