<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserPermissionEnum;
use App\Models\User;
use App\Models\WarehouseObject;


class WarehouseObjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectViewAny->value);
    }

    public function view(User $user, WarehouseObject $warehouseObject): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectCreate->value);
    }

    public function update(User $user, WarehouseObject $warehouseObject): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectEdit->value);
    }

    public function delete(User $user, WarehouseObject $warehouseObject): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectDelete->value);
    }

    public function restore(User $user, WarehouseObject $warehouseObject): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectRestore->value);
    }

    public function forceDelete(User $user, WarehouseObject $warehouseObject): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseObjectDeleteForce->value);
    }
}
