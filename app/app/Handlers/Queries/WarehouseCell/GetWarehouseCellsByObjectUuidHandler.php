<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseCell;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\WarehouseCell\GetWarehouseCellsByObjectUuidQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseCellRepository;


class GetWarehouseCellsByObjectUuidHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    /**
     * @param GetWarehouseCellsByObjectUuidQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findByObjectUuid($query->objectUuid);
    }
}
