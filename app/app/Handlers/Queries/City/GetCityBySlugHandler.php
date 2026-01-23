<?php

declare(strict_types=1);

namespace App\Handlers\Queries\City;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Queries\City\GetCityBySlugQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\CityRepository;


class GetCityBySlugHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly CityRepository $repository
    )
    {
    }

    /**
     * @param GetCityBySlugQuery $query
     * @return City|Model|null
     */
    public function handleWithoutCache(QueryInterface $query): City | Model | null
    {
        return $this->repository->findBySlug($query->slug);
    }
}
