<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Enums\UserPermissionEnum;


class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserViewAny->value);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserCreate->value);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserEdit->value);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserDelete->value);
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserRestore->value);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::UserDeleteForce->value);
    }
}
