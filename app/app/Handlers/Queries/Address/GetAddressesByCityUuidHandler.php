<?php

declare(strict_types=1);

namespace App\Handlers\Queries\Address;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\Address\GetAddressesByCityUuidQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\AddressRepository;


class GetAddressesByCityUuidHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly AddressRepository $repository
    )
    {
    }

    /**
     * @param GetAddressesByCityUuidQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findByCityUuid($query->cityUuid);
    }
}
