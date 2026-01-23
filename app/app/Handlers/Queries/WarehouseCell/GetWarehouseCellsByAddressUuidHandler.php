<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseCell;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\WarehouseCell\GetWarehouseCellsByAddressUuidQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseCellRepository;

class GetWarehouseCellsByAddressUuidHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    /**
     * @param GetWarehouseCellsByAddressUuidQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findByAddressUuid($query->addressUuid);
    }
}
