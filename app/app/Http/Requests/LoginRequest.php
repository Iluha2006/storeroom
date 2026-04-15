<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле email обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',

            'password.required' => 'Поле пароль обязательно для заполнения',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'email',
            'password' => 'пароль',
        ];
    }
}