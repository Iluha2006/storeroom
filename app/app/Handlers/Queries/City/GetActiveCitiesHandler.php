<?php

declare(strict_types=1);

namespace App\Handlers\Queries\City;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\City\GetActiveCitiesQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\CityRepository;


class GetActiveCitiesHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly CityRepository $repository
    )
    {
    }

    /**
     * @param GetActiveCitiesQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findActive();
    }
}
