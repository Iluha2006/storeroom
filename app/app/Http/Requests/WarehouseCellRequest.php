<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseCellRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'warehouse_object_id' => ['required', 'exists:warehouse_objects'],
            'status' => ['required', 'integer'],
            'slug' => ['nullable'],
            'floor' => ['nullable', 'integer'],
            'row' => ['nullable'],
            'section' => ['nullable'],
            'level' => ['nullable'],
            'number' => ['required'],
            'length' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'width' => ['required', 'integer'],
            'volume' => ['required', 'integer'],
            'how_to_get_there' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
