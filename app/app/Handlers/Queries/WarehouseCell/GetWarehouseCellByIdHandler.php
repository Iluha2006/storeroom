<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseCell;

use Illuminate\Database\Eloquent\Model;
use App\Models\WarehouseCell;
use App\Queries\WarehouseCell\GetWarehouseCellByIdQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseCellRepository;


class GetWarehouseCellByIdHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseCellRepository $repository
    )
    {
    }

    /**
     * @param GetWarehouseCellByIdQuery $query
     * @return WarehouseCell|Model|null
     */
    public function handleWithoutCache(QueryInterface $query): WarehouseCell | Model | null
    {
        return $this->repository->findById($query->id);
    }
}
