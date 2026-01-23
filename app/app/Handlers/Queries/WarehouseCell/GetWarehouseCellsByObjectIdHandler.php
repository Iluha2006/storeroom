<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseCell;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\WarehouseCell\GetWarehouseCellsByObjectIdQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseCellRepository;


class GetWarehouseCellsByObjectIdHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    /**
     * @param GetWarehouseCellsByObjectIdQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findByObjectId($query->objectId);
    }
}
