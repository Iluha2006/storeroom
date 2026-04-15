<?php

namespace App\Services;

use App\Interfaces\CacheServiceInterface;
use App\Models\WarehouseCell;
use App\Http\Resources\WarehouseCellResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class WarehouseCellService
{
    public function __construct(
        private readonly CacheServiceInterface $cacheService
    ) {}


    public function getCellsByCity(string $citySlug): Collection
{
    $cacheKey = "warehouse_cells_city_{$citySlug}";
    $cacheTags = ['warehouse_cells', "city:{$citySlug}"];
    $cacheTtl = 1800;

    return $this->cacheService->rememberWithTags(
        $cacheKey,
        $cacheTags,
        $cacheTtl,
        function () use ($citySlug) {
            return WarehouseCell::with([
                'object',
                'object.address',
                'object.address.city',
                'object.organization'
            ])
            ->whereHas('object', function ($query) {
                $query->where('is_active', true);
            })
            ->whereHas('object.address.city', function ($query) use ($citySlug) {
                $query->where('slug', $citySlug);
            })
            ->get();
        }
    );
}


    public function getCellBySlug(string $cellSlug): ?WarehouseCell
    {
        $cacheKey = "warehouse_cell_{$cellSlug}";
        $cacheTags = ['warehouse_cells', 'warehouse_cell_detail'];
        $cacheTtl = 3600;

        return $this->cacheService->rememberWithTags(
            $cacheKey,
            $cacheTags,
            $cacheTtl,
            function () use ($cellSlug) {
                $cell = WarehouseCell::with([
                    'object',
                    'object.address',
                    'object.address.city'
                ])->where('slug', $cellSlug)->first();


                return $cell ?: null;
            }
        );
    }


    public function getAllCells(): Collection
    {
        $cacheKey = 'warehouse_cells_all';
        $cacheTags = ['warehouse_cells', 'warehouse_cells_all'];
        $cacheTtl = 900;

        return $this->cacheService->rememberWithTags(
            $cacheKey,
            $cacheTags,
            $cacheTtl,
            function () {
                return WarehouseCell::with([
                    'object',
                    'object.address',
                    'object.address.city',
                    'object.organization'
                ])
               ->where('status', \App\Enums\WarehouseCellStatusEnum::Available->value)
                ->whereHas('object', function ($query) {
                    $query->where('is_active', true);
                })
                ->get();
            }
        );
    }
    public function invalidateCellCache(int $cellId): void
    {
        try {

            $this->cacheService->flushTags(['warehouse_cells_all']);

            Log::channel('queries')->info('Cell cache invalidated', ['cell_id' => $cellId]);
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to invalidate cell cache', [
                'cell_id' => $cellId,
                'error' => $e->getMessage()
            ]);
        }
    }


    public function invalidateCityCache(string $citySlug): void
    {
        try {
            $this->cacheService->flushTags([
                "city:{$citySlug}",
                'warehouse_cells'
            ]);

            Log::channel('queries')->info('City cache invalidated', ['city_slug' => $citySlug]);
        } catch (\Exception $e) {
            Log::channel('queries')->error('Failed to invalidate city cache', [
                'city_slug' => $citySlug,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function toResource(Collection $cells): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return WarehouseCellResource::collection($cells);
    }

    public function toSingleResource(?WarehouseCell $cell): ?WarehouseCellResource
    {
        return $cell ? new WarehouseCellResource($cell) : null;
    }
}