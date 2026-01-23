<?php

declare(strict_types=1);

namespace App\Queries\WarehouseCell;

use App\Queries\BaseQuery;


final readonly class GetWarehouseCellsByObjectIdQuery extends BaseQuery
{
    public function __construct(
        public int $objectId
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 1800;
    }

    public function getCacheTags(): array
    {
        return ['warehouse_cells', "warehouse_object:{$this->objectId}"];
    }
}

