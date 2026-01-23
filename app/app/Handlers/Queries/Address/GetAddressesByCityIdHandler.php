<?php

declare(strict_types=1);

namespace App\Handlers\Queries\Address;

use Illuminate\Database\Eloquent\Collection;
use App\Queries\Address\GetAddressesByCityIdQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\AddressRepository;


class GetAddressesByCityIdHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly AddressRepository $repository
    )
    {
    }

    /**
     * @param GetAddressesByCityIdQuery $query
     * @return Collection
     */
    public function handleWithoutCache(QueryInterface $query): Collection
    {
        return $this->repository->findByCityId($query->cityId);
    }
}
