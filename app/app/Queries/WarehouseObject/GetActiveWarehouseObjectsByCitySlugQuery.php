<?php

declare(strict_types=1);

namespace App\Queries\WarehouseObject;

use App\Queries\BaseQuery;


final readonly class GetActiveWarehouseObjectsByCitySlugQuery extends BaseQuery
{
    public function __construct(
        public string $citySlug
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 1800;
    }

    public function getCacheTags(): array
    {
        return ['warehouse_objects', 'active_warehouse_objects'];
    }
}
