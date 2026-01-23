<?php

declare(strict_types=1);

namespace App\Handlers\Queries;

use Illuminate\Support\Facades\Cache;
use App\Interfaces\QueryInterface;
use App\Interfaces\QueryHandlerInterface;


abstract class BaseQueryHandler implements QueryHandlerInterface
{
    /**
     * Выполнить запрос с кешированием
     */
    public function handle(QueryInterface $query): mixed
    {
        $ttl = $query->getCacheTtl();

        // Если кеширование не требуется
        if ($ttl === null) {
            return $this->handleWithoutCache($query);
        }

        $cacheKey = $query->getCacheKey();
        $cacheTags = $query->getCacheTags();

        // С тегами
        if (!empty($cacheTags)) {
            return Cache::tags($cacheTags)->remember(
                $cacheKey,
                $ttl,
                fn() => $this->handleWithoutCache($query)
            );
        }

        // Без тегов
        return Cache::remember(
            $cacheKey,
            $ttl,
            fn() => $this->handleWithoutCache($query)
        );
    }

    /**
     * Выполнить запрос без кеширования
     */
    abstract public function handleWithoutCache(QueryInterface $query): mixed;
}
