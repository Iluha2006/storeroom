<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\WarehouseCellService;
use Illuminate\Http\JsonResponse;

class WarehouseCellController extends Controller
{
    public function __construct(
        private readonly WarehouseCellService $cellService
    ) {}

    public function indexByCity(string $citySlug): JsonResponse
    {
        $cells = $this->cellService->getCellsByCity($citySlug);

        return response()->json([
            'success' => true,
            'data' => $this->cellService->toResource($cells)
        ]);
    }

    public function show(string $cellSlug): JsonResponse
    {
        $cell = $this->cellService->getCellBySlug($cellSlug);

        if (!$cell) {
            return response()->json([
                'success' => false,
                'message' => 'Ячейка не найдена'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->cellService->toSingleResource($cell)
        ]);
    }

    public function indexAll(): JsonResponse
    {
        $cells = $this->cellService->getAllCells();

        return response()->json([
            'success' => true,
            'data' => $this->cellService->toResource($cells)
        ]);
    }


    public function clearCacheForCell(int $cellId): JsonResponse
    {
        $this->cellService->invalidateCellCache($cellId);

        return response()->json([
            'success' => true,
            'message' => 'Кэш ячейки очищен'
        ]);
    }

    public function clearCacheForCity(string $citySlug): JsonResponse
    {
        $this->cellService->invalidateCityCache($citySlug);

        return response()->json([
            'success' => true,
            'message' => 'Кэш города очищен'
        ]);
    }
}
