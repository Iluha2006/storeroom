<?php

namespace App\Providers;

use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Редиректы после аутентификации
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful. Please verify your email.',
                    'redirect' => '/email/verify'
                ], 200);
            }
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                return response()->json([
                    'success' => true,
                    'user' => $request->user()->only(['id', 'name', 'email', 'email_verified_at']),
                    'redirect' => '/dashboard'
                ], 200);
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully',
                    'redirect' => '/'
                ], 200);
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                if (Features::enabled(Features::emailVerification()) && !$user->hasVerifiedEmail()) {
                    return null;
                }

                $user->setAttribute('last_login_at', new \DateTimeImmutable());
                $user->save();
                return $user;
            }
        });


        Fortify::loginView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });

        Fortify::registerView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });

        Fortify::requestPasswordResetLinkView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });

        Fortify::resetPasswordView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });

        Fortify::verifyEmailView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });


        Fortify::verifyEmailView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });


        Fortify::confirmPasswordView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });


        Fortify::twoFactorChallengeView(function () {
            return response()->json(['error' => 'Unauthorized'], 401);
        });
    }
}
