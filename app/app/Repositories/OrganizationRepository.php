<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Organization;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;


class OrganizationRepository extends BaseRepository
{
    public function __construct(Organization $model)
    {
        parent::__construct($model);
    }

    public function findActive(): Collection
    {
        return $this->findByStatus(OrganizationStatusEnum::Active);
    }

    public function findById(int $id, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('id', $id)
            ->where('status', $status)
            ->first();
    }

    public function findByUuid(string $uuid, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('uuid', $uuid)
            ->where('status', $status)
            ->first();
    }

    public function findByStatus(OrganizationStatusEnum $status): Collection
    {
        return $this->newQuery()
            ->where('status', $status)
            ->orderBy('name')
            ->get();
    }

    public function findByType(OrganizationTypeEnum $type, ?OrganizationStatusEnum $status = null): Collection
    {
        return $this->newQuery()
            ->where('status', $status)
            ->where('type', $type)
            ->orderBy('name')
            ->get();
    }

    public function findByInn(string $inn, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('status', $status)
            ->where('inn', $inn)
            ->first();
    }

    public function findByKpp(string $kpp, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('status', $status)
            ->where('kpp', $kpp)
            ->first();
    }

    public function findByOgrn(string $ogrn, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('status', $status)
            ->where('ogrn', $ogrn)
            ->first();
    }

    public function findByUserId(int $userId, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('status', $status)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->first();
    }

    public function findByUserUuid(string $userUuid, ?OrganizationStatusEnum $status = null): Organization | Model | null
    {
        return $this->newQuery()
            ->where('status', $status)
            ->whereHas('users', function ($query) use ($userUuid) {
                $query->where('uuid', $userUuid);
            })
            ->first();
    }
}
