<?php

declare(strict_types=1);

namespace App\Queries\WarehouseCell;

use App\Queries\BaseQuery;


final readonly class GetAvailableWarehouseCellsBySlugQuery extends BaseQuery
{
    public function __construct(
        public ?string $citySlug = null,
        public ?string $addressSlug = null,
        public ?string $objectSlug = null,
        public int     $perPage = 15
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 600;
    }

    public function getCacheTags(): array
    {
        $tags = ['warehouse_cells', 'available_cells'];

        if ($this->objectSlug) {
            $tags[] = "warehouse_object:{$this->objectSlug}";
        }

        return $tags;
    }
}
