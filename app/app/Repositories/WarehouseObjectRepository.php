<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\WarehouseObject;


class WarehouseObjectRepository extends BaseRepository
{
    public function __construct(WarehouseObject $model)
    {
        parent::__construct($model);
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

    public function findByAddressId(int $addressId): Collection
    {
        return $this->newQuery()
            ->where('address_id', $addressId)
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
}
