<?php

declare(strict_types=1);

namespace App\Interfaces;


interface QueryHandlerInterface
{
    /**
     * Обработка запроса с кешированием
     */
    public function handle(QueryInterface $query): mixed;

    /**
     * Обработка запроса без кеширования
     */
    public function handleWithoutCache(QueryInterface $query): mixed;
}
