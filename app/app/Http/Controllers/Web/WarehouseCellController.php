<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseCellResource;
use App\Handlers\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugHandler;
use App\Handlers\Queries\WarehouseCell\GetAvailableWarehouseCellBySlugHandler;
use App\Models\WarehouseCell;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugQuery;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellBySlugQuery;
use Illuminate\Http\JsonResponse;
use Symfony\Component\BrowserKit\Request;

class WarehouseCellController extends Controller
{
    public function index(
        GetAvailableWarehouseCellsBySlugHandler $handler,
        string $citySlug,
        string $objectSlug
    ): JsonResponse
    {
        $cells = $handler->handle(new GetAvailableWarehouseCellsBySlugQuery(
            citySlug: $citySlug,
            objectSlug: $objectSlug
        ));

        return response()->json([
            'success' => true,
            'data' => WarehouseCellResource::collection($cells),
        ]);
    }




public function indexByCity(string $citySlug): JsonResponse
{
    $cells = \App\Models\WarehouseCell::with([
        'object',
        'object.address.city',
        'object.organization'
    ])
    ->where('status', \App\Enums\WarehouseCellStatusEnum::Available->value)
    ->whereHas('object', function ($query) {
        $query->where('is_active', true);
    })
    ->whereHas('object.address.city', function ($query) use ($citySlug) {
        $query->where('slug', $citySlug);
    })
    ->get();

    return response()->json([
        'success' => true,
        'data' => \App\Http\Resources\WarehouseCellResource::collection($cells)
    ]);
}

    public function show(
        GetAvailableWarehouseCellBySlugHandler $handler,
        string $cellSlug
    ): JsonResponse
    {
        $cell = $handler->handle(new GetAvailableWarehouseCellBySlugQuery(slug: $cellSlug));

        return response()->json([
            'success' => true,
            'data' => new WarehouseCellResource($cell)
        ]);
    }



}