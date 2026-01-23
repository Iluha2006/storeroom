<?php

declare(strict_types=1);

namespace App\Queries\City;

use App\Queries\BaseQuery;


final readonly class GetCityByIdQuery extends BaseQuery
{
    public function __construct(
        public int $id
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 3600;
    }

    public function getCacheTags(): array
    {
        return ['cities', "city:{$this->id}"];
    }
}
