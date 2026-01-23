<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseObject;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseObjectRepository;


class GetActiveWarehouseObjectsByCitySlugHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseObjectRepository $repository
    )
    {
    }

    /**
     * @param GetActiveWarehouseObjectsByCitySlugQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->getActiveByCitySlug(citySlug: $query->citySlug);
    }
}
