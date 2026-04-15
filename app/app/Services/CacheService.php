<?php

namespace App\Services;

use App\Interfaces\CacheServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheService implements CacheServiceInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    public function put(string $key, mixed $value, ?int $ttl = null): bool
    {
        try {
            if ($ttl !== null) {
                Cache::put($key, $value, $ttl);
            } else {
                Cache::put($key, $value);
            }

            Log::channel('queries')->debug('Cache put', [
                'key' => $key,
                'ttl' => $ttl,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to put cache', [
                'key' => $key,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function putWithTags(string $key, mixed $value, array $tags, ?int $ttl = null): bool
    {
        try {
            if (empty($tags)) {
                return $this->put($key, $value, $ttl);
            }

            if ($ttl !== null) {
                Cache::tags($tags)->put($key, $value, $ttl);
            } else {
                Cache::tags($tags)->put($key, $value);
            }

            Log::channel('queries')->debug('Cache put with tags', [
                'key' => $key,
                'tags' => $tags,
                'ttl' => $ttl,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to put cache with tags', [
                'key' => $key,
                'tags' => $tags,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
    public function rememberWithTags(string $key, array $tags, int $ttl, \Closure $callback): mixed
{
    return Cache::tags($tags)->remember($key, $ttl, $callback);
}
    public function getWithTags(string $key, array $tags, mixed $default = null): mixed
    {
        if (empty($tags)) {
            return $this->get($key, $default);
        }

        return Cache::tags($tags)->get($key, $default);
    }

    public function remember(string $key, int $ttl, \Closure $callback): mixed
    {
        try {
            return Cache::remember($key, $ttl, $callback);
        } catch (\Exception $e) {
            Log::channel('queries')->error('Cache failed, falling back to database', [
                'key' => $key,
                'error' => $e->getMessage(),
            ]);

            return $callback();
        }
    }





    public function forget(string $key): bool
    {
        try {
            $result = Cache::forget($key);

            Log::channel('queries')->debug('Cache forget', [
                'key' => $key,
                'result' => $result,
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to forget cache', [
                'key' => $key,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function flushTags(array $tags): void
    {
        if (empty($tags)) {
            return;
        }

        try {
            Cache::tags($tags)->flush();

            Log::channel('queries')->debug('Cache flushed', [
                'tags' => $tags,
            ]);
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to flush cache', [
                'tags' => $tags,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function flushAll(): void
    {
        try {
            Cache::flush();

            Log::channel('queries')->warning('All cache flushed');
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to flush all cache', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Сбросить кеш для конкретной модели
     */
    public function flushModel(string $modelClass, int $id): void
    {
        $modelName = class_basename($modelClass);
        $tags = [
            strtolower($modelName) . 's', // warehouse_cells
            strtolower($modelName) . ":{$id}", // warehouse_cell:123
        ];

        $this->flushTags($tags);
    }
}