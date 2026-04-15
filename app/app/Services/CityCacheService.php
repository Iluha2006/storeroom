<?php

namespace App\Services;

use App\Interfaces\CacheServiceInterface;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CityCacheService
{
    public function __construct(
        private readonly CacheServiceInterface $cacheService
    ) {}


    public function getActiveCities(): Collection
    {
        $cacheKey = 'active_cities';
        $cacheTags = ['cities', 'active_cities'];
        $cacheTtl = 3600;

        return $this->cacheService->rememberWithTags(
            $cacheKey,
            $cacheTags,
            $cacheTtl,
            function () {
                return City:: where('is_active', true)
                    ->orderBy('name')
                    ->get();
            }
        );
    }
}