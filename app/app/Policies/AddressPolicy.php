<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserPermissionEnum;
use App\Models\User;
use App\Models\Address;


class AddressPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressViewAny->value);
    }

    public function view(User $user, Address $address): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressCreate->value);
    }

    public function update(User $user, Address $address): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressEdit->value);
    }

    public function delete(User $user, Address $address): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressDelete->value);
    }

    public function restore(User $user, Address $address): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressRestore->value);
    }

    public function forceDelete(User $user, Address $address): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::AddressDeleteForce->value);
    }
}
