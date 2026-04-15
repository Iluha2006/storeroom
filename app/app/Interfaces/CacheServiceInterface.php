<?php

namespace App\Interfaces;

interface CacheServiceInterface
{
    /**
     * Получить данные из кэша
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Сохранить данные в кэш
     */
    public function put(string $key, mixed $value, ?int $ttl = null): bool;

    /**
     * Сохранить данные в кэш с тегами
     */
    public function putWithTags(string $key, mixed $value, array $tags, ?int $ttl = null): bool;

    /**
     * Получить данные из кэша с тегами
     */
    public function getWithTags(string $key, array $tags, mixed $default = null): mixed;

    /**
     * Сохранить если ключ не существует
     */
    public function remember(string $key, int $ttl, \Closure $callback): mixed;


    public function rememberWithTags(string $key, array $tags, int $ttl, \Closure $callback): mixed;


    public function forget(string $key): bool;

    public function flushTags(array $tags): void;

    /**
     * Очистить весь кэш
     */
    public function flushAll(): void;

    /**
     * Проверить наличие ключа
     */
    public function has(string $key): bool;
}
