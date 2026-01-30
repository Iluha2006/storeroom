<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugQuery;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugQuery;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugHandler;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugHandler;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\WarehouseObjectResource;

class WarehouseObjectController extends Controller
{
    public function index(
        GetActiveWarehouseObjectsByCitySlugHandler $handler,
        string $citySlug
    ): JsonResponse
    {
        $objects = $handler->handle(new GetActiveWarehouseObjectsByCitySlugQuery($citySlug));

        return response()->json([
            'success' => true,
            'data' => WarehouseObjectResource::collection($objects)
        ]);
    }

    public function show(
        GetActiveWarehouseObjectBySlugAndCitySlugHandler $handler,
        string $citySlug,
        string $objectSlug
    ): JsonResponse
    {
        $object = $handler->handle(new GetActiveWarehouseObjectBySlugAndCitySlugQuery(
            slug: $objectSlug,
            citySlug: $citySlug
        ));
  return response()->json([
            'success' => true,
            'data' => new WarehouseObjectResource($object)
        ]);
    }
}



