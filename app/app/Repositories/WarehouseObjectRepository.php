<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\WarehouseObject;


class WarehouseObjectRepository extends BaseRepository
{
    public function __construct(WarehouseObject $model)
    {
        parent::__construct($model);
    }

    public function getActiveBySlugAndCitySlug(string $slug, string $citySlug): WarehouseObject | Model | null
    {
        return $this->newQuery()
           ->with(['address', 'organization', 'cells' ])
            ->where('is_active', true)
            ->where('slug', $slug)
            ->whereHas('address', function ($query) use ($citySlug) {
                $query->whereHas('city', function ($query) use ($citySlug) {
                    $query->where('slug', $citySlug);
                });
            })
            ->first();
    }

    public function getActiveByCitySlug(string $citySlug): Collection
    {
        return $this->newQuery()
            ->with(['address', 'organization', 'cells'])
            ->where('is_active', true)
            ->whereHas('address.city', fn($q) => $q->where('slug', $citySlug))
            ->get();
    }
    public function findActive(): Collection
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->get();
    }

    public function findByOrganizationId(int $organizationId): Collection
    {
        return $this->newQuery()
            ->where('organization_id', $organizationId)
            ->get();
    }

    public function findByOrganizationUuid(string $organizationUuid): Collection
    {
        return $this->newQuery()
            ->whereHas('organization', function ($query) use ($organizationUuid) {
                $query->where('uuid', $organizationUuid);
            })
            ->get();
    }

    public function findByAddressId(int $addressId): Collection
    {
        return $this->newQuery()
            ->where('address_id', $addressId)
            ->get();
    }

    public function findByAddressUuid(string $addressUuid): Collection
    {
        return $this->newQuery()
            ->whereHas('address', function ($query) use ($addressUuid) {
                $query->where('uuid', $addressUuid);
            })
            ->get();
    }

    public function findByCityId(int $cityId): Collection
    {
        return $this->newQuery()
            ->whereHas('address', function ($query) use ($cityId) {
                $query->where('city_id', $cityId);
            })
            ->get();
    }

    public function findByCityUuid(string $cityUuid): Collection
    {
        return $this->newQuery()
            ->whereHas('address', function ($query) use ($cityUuid) {
                $query->whereHas('city', function ($query) use ($cityUuid) {
                    $query->where('uuid', $cityUuid);
                });
            })
            ->get();
    }
}
