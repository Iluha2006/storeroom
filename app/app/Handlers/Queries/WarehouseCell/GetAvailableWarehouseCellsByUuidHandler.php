<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseCell;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellsByUuidQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseCellRepository;


class GetAvailableWarehouseCellsByUuidHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    /**
     * @param GetAvailableWarehouseCellsByUuidQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->getAvailableCellsByUuid(
            cityUuid: $query->cityUuid,
            addressUuid: $query->addressUuid,
            objectUuid: $query->objectUuid
        );
    }
}
