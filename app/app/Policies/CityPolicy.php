<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserPermissionEnum;
use App\Models\User;
use App\Models\City;


class CityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityViewAny->value);
    }

    public function view(User $user, City $city): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityCreate->value);
    }

    public function update(User $user, City $city): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityEdit->value);
    }

    public function delete(User $user, City $city): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityDelete->value);
    }

    public function restore(User $user, City $city): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityRestore->value);
    }

    public function forceDelete(User $user, City $city): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::CityDeleteForce->value);
    }
}
