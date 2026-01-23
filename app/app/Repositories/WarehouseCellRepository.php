<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\WarehouseCell;
use App\Enums\WarehouseCellStatusEnum;


class WarehouseCellRepository extends BaseRepository
{
    public function __construct(WarehouseCell $model)
    {
        parent::__construct($model);
    }

    public function getAvailable(): Collection
    {
        return $this->findByStatus(WarehouseCellStatusEnum::Available);
    }

    public function getAvailableCellsBySlug(?string $citySlug, ?string $addressSlug, ?string $objectSlug): Collection
    {
        return $this->newQuery()
            ->where('status', WarehouseCellStatusEnum::Available)
            ->when($objectSlug, function ($query, $objectSlug) {
                $query->whereHas('object', function ($query) use ($objectSlug) {
                    $query->where('slug', $objectSlug);
                });
            })
            ->whereHas('address', function ($query) use ($citySlug, $addressSlug) {
                $query
                    ->when($addressSlug, function ($query, $addressSlug) {
                        $query->where('slug', $addressSlug);
                    })
                    ->whereHas('city', function ($query) use ($citySlug) {
                        $query->when($citySlug, function ($query, $citySlug) {
                            $query->where('slug', $citySlug);
                        });
                    });
            })
            ->get();
    }

    public function getAvailableCellsByUuid(?string $cityUuid, ?string $addressUuid, ?string $objectUuid): Collection
    {
        return $this->newQuery()
            ->where('status', WarehouseCellStatusEnum::Available)
            ->when($objectUuid, function ($query, $objectUuid) {
                $query->whereHas('object', function ($query) use ($objectUuid) {
                    $query->where('uuid', $objectUuid);
                });
            })
            ->whereHas('address', function ($query) use ($cityUuid, $addressUuid) {
                $query
                    ->when($addressUuid, function ($query, $addressUuid) {
                        $query->where('uuid', $addressUuid);
                    })
                    ->whereHas('city', function ($query) use ($cityUuid) {
                        $query->when($cityUuid, function ($query, $cityUuid) {
                            $query->where('uuid', $cityUuid);
                        });
                    });
            })
            ->get();
    }

    public function getAvailableCellBySlug(string $slug): WarehouseCell | Model | null
    {
        return $this->newQuery()
            ->where('status', WarehouseCellStatusEnum::Available)
            ->where('slug', $slug)
            ->first();
    }

    public function findByStatus(WarehouseCellStatusEnum $status): Collection
    {
        return $this->newQuery()
            ->where('status', $status)
            ->get();
    }

    public function findByObjectId(int $objectId, ?WarehouseCellStatusEnum $status = null): Collection
    {
        return $this->newQuery()
            ->where('warehouse_object_id', $objectId)
            ->where('status', $status)
            ->get();
    }

    public function findByObjectUuid(string $objectUuid, ?WarehouseCellStatusEnum $status = null): Collection
    {
        return $this->newQuery()
            ->whereHas('object', function ($query) use ($objectUuid) {
                $query->where('uuid', $objectUuid);
            })
            ->where('status', $status)
            ->get();
    }

    public function findByAddressId(int $addressId, ?WarehouseCellStatusEnum $status = null): Collection
    {
        return $this->newQuery()
            ->whereHas('address', function ($query) use ($addressId) {
                $query->where('id', $addressId);
            })
            ->where('status', $status)
            ->get();
    }

    public function findByAddressUuid(string $addressUuid, ?WarehouseCellStatusEnum $status = null): Collection
    {
        return $this->newQuery()
            ->whereHas('address', function ($query) use ($addressUuid) {
                $query->where('uuid', $addressUuid);
            })
            ->where('status', $status)
            ->get();
    }
}
