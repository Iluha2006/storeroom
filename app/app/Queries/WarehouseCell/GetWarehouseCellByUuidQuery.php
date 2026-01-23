<?php

declare(strict_types=1);

namespace App\Queries\WarehouseCell;

use App\Queries\BaseQuery;


final readonly class GetWarehouseCellByUuidQuery extends BaseQuery
{
    public function __construct(
        public string $uuid
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 3600;
    }

    public function getCacheTags(): array
    {
        return ['warehouse_cells'];
    }
}
