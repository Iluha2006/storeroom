<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class AddressRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->paginationRules(),
            [
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
            ]
        );
    }
}
