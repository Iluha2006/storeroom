<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserPermissionEnum;
use App\Models\User;
use App\Models\Organization;


class OrganizationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationViewAny->value);
    }

    public function view(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationCreate->value);
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationEdit->value);
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationDelete->value);
    }

    public function restore(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationRestore->value);
    }

    public function forceDelete(User $user, Organization $organization): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::OrganizationDeleteForce->value);
    }
}
