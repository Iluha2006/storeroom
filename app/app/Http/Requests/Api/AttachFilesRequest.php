<?php

namespace App\Http\Requests\Api;
<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
use Illuminate\Validation\Rule;
use App\Http\Requests\ApiRequest;
use App\Enums\FileCollectionEnum;

<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
class AttachFilesRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }
<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    public function rules(): array
    {
        return [
            'files' => ['required', 'array', 'min:1', 'max:10'],
            'files.*' => ['required', 'file', 'max:5120'], // 5MB max
            'collection' => ['required', Rule::enum(FileCollectionEnum::class)],
        ];
    }
<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    public function messages(): array
    {
        return [
            'files.required' => 'At least one file is required',
            'files.*.file' => 'Each item must be a valid file',
            'files.*.max' => 'File size must not exceed 5MB',
            'collection.required' => 'Collection is required',
        ];
    }
}
