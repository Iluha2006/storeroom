<?php

declare(strict_types=1);

namespace App\Interfaces;


interface QueryInterface
{
    /**
     * Получить ключ кеша для запроса
     */
    public function getCacheKey(): string;

    /**
     * Получить время жизни кеша в секундах (null = не кешировать)
     */
    public function getCacheTtl(): ?int;

    /**
     * Теги кеша для группового сброса
     */
    public function getCacheTags(): array;
}
