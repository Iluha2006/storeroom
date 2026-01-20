<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserPermissionEnum;
use App\Models\User;
use App\Models\WarehouseCell;


class WarehouseCellPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellViewAny->value);
    }

    public function view(User $user, WarehouseCell $warehouseCell): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellView->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellCreate->value);
    }

    public function update(User $user, WarehouseCell $warehouseCell): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellEdit->value);
    }

    public function delete(User $user, WarehouseCell $warehouseCell): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellDelete->value);
    }

    public function restore(User $user, WarehouseCell $warehouseCell): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellRestore->value);
    }

    public function forceDelete(User $user, WarehouseCell $warehouseCell): bool
    {
        return $user->hasPermissionTo(UserPermissionEnum::WarehouseCellDeleteForce->value);
    }
}
