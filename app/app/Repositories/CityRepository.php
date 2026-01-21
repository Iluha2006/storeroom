<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\City;


class CityRepository extends BaseRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function findActive(): Collection
    {
        return $this->newQuery()
            ->where('is_active', true)
            ->get();
    }

    public function findByName(string $name): City | Model | null
    {
        return $this->newQuery()
            ->where('name', 'like', "%{$name}%")
            ->first();
    }
}
