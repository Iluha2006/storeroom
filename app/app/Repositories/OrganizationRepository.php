<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Organization;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;


class OrganizationRepository extends BaseRepository
{
    public function __construct(Organization $model)
    {
        parent::__construct($model);
    }

    public function findActive(): Collection
    {
        return $this->findByStatus(OrganizationStatusEnum::Active);
    }

    public function findByInn(string $inn): Organization | Model | null
    {
        return $this->newQuery()
            ->where('inn', $inn)
            ->first();
    }

    public function findByStatus(OrganizationStatusEnum $status): Collection
    {
        return $this->newQuery()
            ->where('status', $status)
            ->get();
    }

    public function findByType(OrganizationTypeEnum $type): Collection
    {
        return $this->newQuery()
            ->where('type', $type)
            ->get();
    }
}
