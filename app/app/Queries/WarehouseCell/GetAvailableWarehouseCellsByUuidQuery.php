<?php

declare(strict_types=1);

namespace App\Queries\WarehouseCell;

use App\Queries\BaseQuery;


final readonly class GetAvailableWarehouseCellsByUuidQuery extends BaseQuery
{
    public function __construct(
        public ?string $cityUuid = null,
        public ?string $addressUuid = null,
        public ?string $objectUuid = null,
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

        if ($this->objectUuid) {
            $tags[] = "warehouse_object:{$this->objectUuid}";
        }

        return $tags;
    }
}
