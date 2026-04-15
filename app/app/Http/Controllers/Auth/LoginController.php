<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            return $this->error(
                message: 'Пожалуйста, подтвердите ваш email перед входом',
                code: 422,
                errors: [
                    'email' => 'Пожалуйста, подтвердите ваш email перед входом'
                ]
            );
        }


        if (!$user || !Auth::attempt($request->only('email', 'password'))) {
            return $this->error(
                message: 'Неверные учётные данные',
                code: 422,
                errors: [
                    'email' => 'Неверный email или пароль'
                ]
            );
        }

        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->success(
            data: [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
            message: 'Вход выполнен успешно'
        );
    }

    public function logout(Request $request)
    {

        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        Auth::logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return $this->success(
            message: 'Выход выполнен успешно'
        );
    }
}