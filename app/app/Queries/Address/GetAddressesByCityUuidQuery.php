<?php

declare(strict_types=1);

namespace App\Queries\Address;

use App\Queries\BaseQuery;


final readonly class GetAddressesByCityUuidQuery extends BaseQuery
{
    public function __construct(
        public string $cityUuid
    )
    {
    }

    public function getCacheTtl(): ?int
    {
        return 3600;
    }

    public function getCacheTags(): array
    {
        return ['addresses'];
    }
}
