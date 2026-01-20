<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city_id' => ['required', 'exists:cities'],
            'is_active' => ['boolean'],
            'slug' => ['nullable'],
            'street' => ['required'],
            'house' => ['required'],
            'building' => ['nullable'],
            'frame' => ['nullable'],
            'lat' => ['required'],
            'lon' => ['required'],
            'how_to_get_there' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
