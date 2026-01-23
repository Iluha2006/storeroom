<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseCell;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseCellRepository;


class GetAvailableWarehouseCellsBySlugHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    /**
     * @param GetAvailableWarehouseCellsBySlugQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->getAvailableCellsBySlug(
            citySlug: $query->citySlug,
            addressSlug: $query->addressSlug,
            objectSlug: $query->objectSlug
        );
    }
}
