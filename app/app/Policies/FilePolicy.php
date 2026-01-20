<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserPermissionEnum;

class FilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileViewAny->value);
    }

    public function view(User $user, File $file): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileEdit->value);
    }

    public function update(User $user, File $file): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileEdit->value);
    }

    public function delete(User $user, File $file): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileDelete->value);
    }

    public function restore(User $user, File $file): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileRestore->value);
    }

    public function forceDelete(User $user, File $file): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::FileDeleteForce->value);
    }
}
