<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Organization;
use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;


class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'organization_id' => Organization::factory(),
            'status' => $this->faker->randomElement(UserStatusEnum::class),
            'name' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => Carbon::now(),
            'phone' => $this->faker->unique()->e164PhoneNumber(),
            'phone_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'two_factor_secret' => Str::random(10),
            'two_factor_recovery_codes' => Str::random(10),
            'two_factor_confirmed_at' => Carbon::now(),
            'remember_token' => Str::random(10),
            'last_login_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function active(): UserFactory
    {
        return $this->state(fn() => ['status' => UserStatusEnum::Active]);
    }

    public function inactive(): UserFactory
    {
        return $this->state(fn() => ['status' => UserStatusEnum::Inactive]);
    }

    public function blocked(): UserFactory
    {
        return $this->state(fn() => ['status' => UserStatusEnum::Blocked]);
    }

    public function withEmail(string $email): UserFactory
    {
        return $this->state(fn() => ['email' => $email]);
    }

    public function withPhone(string $phone): UserFactory
    {
        return $this->state(fn() => ['phone' => $phone]);
    }

    public function withOrganization(int $organizationId): UserFactory
    {
        return $this->state(fn() => ['organization_id' => $organizationId]);
    }

    public function withoutOrganization(): UserFactory
    {
        return $this->state(fn() => ['organization_id' => null]);
    }

    public function withPassword(string $password): UserFactory
    {
        return $this->state(fn() => ['password' => Hash::make($password)]);
    }

    public function superuser(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::Superuser);
        });
    }

    public function developer(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::Developer);
        });

    }

    public function admin(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::Admin);
        });
    }

    public function moderator(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::Moderator);
        });
    }

    public function partner(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::Partner);
        });
    }

    public function steward(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::Steward);
        });
    }

    public function user(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(UserRoleEnum::User);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): UserFactory
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model does not have two-factor authentication configured.
     */
    public function withoutTwoFactor(): UserFactory
    {
        return $this->state(fn(array $attributes) => [
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }
}
