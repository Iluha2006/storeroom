<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use App\Services\CacheManager;
use App\Models\WarehouseCell;
use App\Models\WarehouseObject;
use App\Models\User;
use App\Models\Organization;


readonly class ModelEventSubscriber
{
    public function __construct(
        private CacheManager $cacheManager
    )
    {
    }

    /**
     * Обработка создания модели
     */
    public function onModelCreated($event): void
    {
        $this->clearModelCache($event);
    }

    /**
     * Обработка обновления модели
     */
    public function onModelUpdated($event): void
    {
        $this->clearModelCache($event);
    }

    /**
     * Обработка удаления модели
     */
    public function onModelDeleted($event): void
    {
        $this->clearModelCache($event);
    }

    /**
     * Сброс кеша модели
     */
    private function clearModelCache(Model $model): void
    {
        $tags = $this->getModelCacheTags($model);

        if (!empty($tags)) {
            $this->cacheManager->flushTags($tags);
        }
    }

    /**
     * Получить теги кеша для модели
     */
    private function getModelCacheTags(Model $model): array
    {
        $modelName = strtolower(class_basename($model));
        $tags = ["{$modelName}s"];

        // Добавляем специфичные теги для разных моделей
        switch (get_class($model)) {
            case WarehouseCell::class:
                $tags[] = "{$modelName}:{$model->id}";
                $tags[] = "warehouse_object:{$model->warehouse_object_id}";

                if ($model->status === \App\Enums\WarehouseCellStatusEnum::Available) {
                    $tags[] = 'available_cells';
                }
                break;

            case WarehouseObject::class:
                $tags[] = "{$modelName}:{$model->id}";
                $tags[] = "organization:{$model->organization_id}";
                $tags[] = "address:{$model->address_id}";
                break;

            case User::class:
                $tags[] = "{$modelName}:{$model->id}";
                if ($model->organization_id) {
                    $tags[] = "organization:{$model->organization_id}";
                }
                break;

            case Organization::class:
                $tags[] = "{$modelName}:{$model->id}";
                break;

            default:
                $tags[] = "{$modelName}:{$model->id}";
        }

        return $tags;
    }

    /**
     * Регистрация слушателей
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            'eloquent.created: App\Models\WarehouseCell',
            [self::class, 'onModelCreated']
        );

        $events->listen(
            'eloquent.updated: App\Models\WarehouseCell',
            [self::class, 'onModelUpdated']
        );

        $events->listen(
            'eloquent.deleted: App\Models\WarehouseCell',
            [self::class, 'onModelDeleted']
        );

        // Добавьте остальные модели по аналогии
        $models = [
            'WarehouseObject',
            'User',
            'Organization',
            'Address',
            'City',
        ];

        foreach ($models as $model) {
            $modelClass = "App\\Models\\{$model}";

            $events->listen(
                "eloquent.created: {$modelClass}",
                [self::class, 'onModelCreated']
            );

            $events->listen(
                "eloquent.updated: {$modelClass}",
                [self::class, 'onModelUpdated']
            );

            $events->listen(
                "eloquent.deleted: {$modelClass}",
                [self::class, 'onModelDeleted']
            );
        }
    }
}
