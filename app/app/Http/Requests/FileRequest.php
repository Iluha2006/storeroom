<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hash' => ['nullable'],
            'disk' => ['required'],
            'path' => ['required'],
            'name' => ['nullable'],
            'filename' => ['required'],
            'original_name' => ['required'],
            'extension' => ['nullable'],
            'mime_type' => ['nullable'],
            'size' => ['nullable', 'integer'],
            'width' => ['nullable', 'integer'],
            'height' => ['nullable', 'integer'],
            'order' => ['required', 'integer'],
            'fileable_type' => ['nullable'],
            'fileable_id' => ['nullable', 'integer'],
            'collection' => ['nullable'],
            'metadata' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
