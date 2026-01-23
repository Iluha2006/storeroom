<?php

declare(strict_types=1);

namespace App\Handlers\Queries\WarehouseObject;

use Illuminate\Database\Eloquent\Model;
use App\Models\WarehouseObject;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\WarehouseObjectRepository;

class GetActiveWarehouseObjectBySlugAndCitySlugHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly WarehouseObjectRepository $repository
    )
    {
    }

    /**
     * @param GetActiveWarehouseObjectBySlugAndCitySlugQuery $query
     * @return WarehouseObject|Model|null
     */
    public function handleWithoutCache(QueryInterface $query): WarehouseObject | Model | null
    {
        return $this->repository->getActiveBySlugAndCitySlug($query->slug, $query->citySlug);
    }
}
