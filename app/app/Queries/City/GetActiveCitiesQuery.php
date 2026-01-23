<?php

declare(strict_types=1);

namespace App\Queries\City;

use App\Queries\BaseQuery;


final readonly class GetActiveCitiesQuery extends BaseQuery
{
    public function __construct(
        public int $perPage = 15
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 3600;
    }

    public function getCacheTags(): array
    {
        return ['cities', 'active_cities'];
    }
}
