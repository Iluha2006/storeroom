<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class CacheManager
{
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

    /**
     * Сбросить кеш для конкретной модели по её классу и идентификатору
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

    /**
     * Получить список активных тегов (для драйверов, поддерживающих это)
     */
    public function getActiveTags(): array
    {
        // Это зависит от драйвера кеша
        // Для Redis можно получить список ключей
        return [];
    }
}
