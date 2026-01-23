<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;


class AddressRepository extends BaseRepository
{
    public function __construct(Address $model)
    {
        parent::__construct($model);
    }

    public function findActive(): Collection
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->get();
    }

    public function findBySlug(string $slug): Address | Model | null
    {
        return $this->newQuery()
            ->where('slug', $slug)
            ->first();
    }

    public function findActiveByUuid(string $uuid): Address | Model | null
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->where('uuid', $uuid)
            ->first();
    }

    public function findActiveBySlug(string $slug): Address | Model | null
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->first();
    }

    public function findByCityId(int $cityId): Collection
    {
        return $this->newQuery()
            ->where('city_id', $cityId)
            ->get();
    }

    public function findByCityUuid(string $cityUuid): Collection
    {
        return $this->newQuery()
            ->whereHas('city', function ($query) use ($cityUuid) {
                $query->where('uuid', $cityUuid);
            })
            ->get();
    }
}
