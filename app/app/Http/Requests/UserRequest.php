<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'integer'],
            'name' => ['required'],
            'lastname' => ['nullable'],
            'email' => ['required', 'email', 'max:254'],
            'email_verified_at' => ['nullable', 'date'],
            'phone' => ['nullable'],
            'phone_verified_at' => ['nullable', 'date'],
            'password' => ['required'],
            'two_factor_secret' => ['nullable'],
            'two_factor_recovery_codes' => ['nullable'],
            'two_factor_confirmed_at' => ['nullable', 'date'],
            'remember_token' => ['nullable'],
            'last_login_at' => ['nullable', 'date'],
            'organization_id' => ['nullable', 'exists:organizations'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
