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

    public function findByObjectId(int $objectId): Collection
    {
        return $this->newQuery()
            ->where('warehouse_object_id', $objectId)
            ->get();
    }

    public function findByStatus(WarehouseCellStatusEnum $status): Collection
    {
        return $this->newQuery()
            ->where('status', $status)
            ->get();
    }

    public function getAvailable(): Collection
    {
        return $this->findByStatus(WarehouseCellStatusEnum::Available);
    }

    public function findByMinVolume(int $minVolume): Collection
    {
        return $this->newQuery()
            ->whereRaw('(length * height * width) >= ?', [$minVolume])
            ->get();
    }

    public function findByPriceRange(float $minPrice, float $maxPrice): Collection
    {
        return $this->newQuery()
            ->whereBetween('price', [$minPrice, $maxPrice])
            ->get();
    }

    public function findByFloor(int $floor): Collection
    {
        return $this->newQuery()
            ->where('floor', $floor)
            ->get();
    }

    public function findByPosition(
        int $objectId,
        int $number,
        int $floor,
        int $row,
        int $section,
        int $level
    ): WarehouseCell | null | Model
    {
        return $this->newQuery()
            ->where('warehouse_object_id', $objectId)
            ->where('floor', $floor)
            ->where('row', $row)
            ->where('section', $section)
            ->where('level', $level)
            ->where('number', $number)
            ->first();
    }
}
