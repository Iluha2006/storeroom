<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendVerificationEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    public function register(RegisterRequest $request)
    {

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {

            SendVerificationEmail::dispatch($existingUser);

            return $this->error(
                message: 'Пользователь с таким email уже существует',
                code: 409,
                errors: [
                    'email' => 'Пользователь с таким email уже зарегистрирован'
                ]
            );
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        SendVerificationEmail::dispatch($user);


        return $this->created(
            data: [
                'user' => $user,
                'requires_verification' => true,
            ],
            message: 'Регистрация успешна. Проверьте почту для подтверждения.'
        );
    }
}