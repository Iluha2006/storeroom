<?php

declare(strict_types=1);

namespace App\Queries\WarehouseCell;

use App\Queries\BaseQuery;


final readonly class GetWarehouseCellsByObjectUuidQuery extends BaseQuery
{
    public function __construct(
        public string $objectUuid
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 1800;
    }

    public function getCacheTags(): array
    {
        return ['warehouse_cells', "warehouse_object:{$this->objectUuid}"];
    }
}

