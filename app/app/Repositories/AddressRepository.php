<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Address;


class AddressRepository extends BaseRepository
{
    public function __construct(Address $model)
    {
        parent::__construct($model);
    }

    public function findByCityId(int $cityId): Collection
    {
        return $this->newQuery()
            ->where('city_id', $cityId)
            ->get();
    }

    public function findActive(): Collection
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->get();
    }

    public function findByCoordinates(float $lat, float $lon, float $radius = 0.0001): Collection
    {
        return $this->newQuery()
            ->whereBetween('lat', [$lat - $radius, $lat + $radius])
            ->whereBetween('lon', [$lon - $radius, $lon + $radius])
            ->get();
    }

    public function search(string $query): Collection
    {
        return $this->newQuery()
            ->where(function ($q) use ($query) {
                $q->where('street', 'like', "%{$query}%")
                    ->orWhere('house', 'like', "%{$query}%");
            })
            ->get();
    }
}
