<?php

declare(strict_types=1);

namespace App\Handlers\Queries\Address;

use Illuminate\Database\Eloquent\Model;
use App\Models\Address;
use App\Queries\Address\GetAddressBySlugQuery;
use App\Handlers\Queries\BaseQueryHandler;
use App\Interfaces\QueryInterface;
use App\Repositories\AddressRepository;


class GetAddressBySlugHandler extends BaseQueryHandler
{
    public function __construct(
        private readonly AddressRepository $repository
    )
    {
    }

    /**
     * @param GetAddressBySlugQuery $query
     * @return Address|Model|null
     */
    public function handleWithoutCache(QueryInterface $query): Address | Model | null
    {
        return $this->repository->findBySlug($query->slug);
    }
}
