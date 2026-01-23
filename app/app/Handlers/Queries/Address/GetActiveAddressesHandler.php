<?php

declare(strict_types=1);

namespace App\Handlers\Queries\Address;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\Address\GetActiveAddressesQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\AddressRepository;


class GetActiveAddressesHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly AddressRepository $repository
    )
    {
    }

    /**
     * @param GetActiveAddressesQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findActive();
    }
}
