<?php

declare(strict_types=1);

namespace App\Queries\Address;

use App\Queries\BaseQuery;


final readonly class GetAddressByUuidQuery extends BaseQuery
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
        return ['addresses', "address:{$this->uuid}"];
    }
}
