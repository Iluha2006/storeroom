<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Enums\UserStatusEnum;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;


class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): User | Model | null
    {
        return $this->newQuery()
            ->where('email', $email)
            ->first();
    }

    public function findByPhone(string $phone): User | Model | null
    {
        return $this->newQuery()
            ->where('phone', $phone)
            ->first();
    }

    public function findByOrganizationId(int $organizationId): Collection
    {
        return $this->newQuery()
            ->where('organization_id', $organizationId)
            ->get();
    }

    public function findByStatus(UserStatusEnum $status): Collection
    {
        return $this->newQuery()
            ->where('status', $status)
            ->get();
    }

    public function findActive(): Collection
    {
        return $this->findByStatus(UserStatusEnum::Active);
    }

    public function findWithoutOrganization(): Collection
    {
        return $this->newQuery()
            ->whereNull('organization_id')
            ->get();
    }

    public function findByPermission(UserPermissionEnum $permission): Collection
    {
        return $this->newQuery()
            ->permission($permission)
            ->get();
    }

    public function findByRole(UserRoleEnum $role): Collection
    {
        return $this->newQuery()
            ->role($role)
            ->get();
    }
}
