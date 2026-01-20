<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseObjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:addresses'],
            'organization_id' => ['required', 'exists:organizations'],
            'is_active' => ['boolean'],
            'name' => ['required'],
            'slug' => ['nullable'],
            'description' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
