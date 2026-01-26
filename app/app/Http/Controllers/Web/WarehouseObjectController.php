<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugQuery;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugQuery;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugHandler;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugHandler;
<<<<<<< HEAD
use Illuminate\Http\JsonResponse;
use App\Http\Resources\WarehouseObjectResource;
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

class WarehouseObjectController extends Controller
{
    public function index(
        GetActiveWarehouseObjectsByCitySlugHandler $handler,
<<<<<<< HEAD
        string $citySlug
    ): JsonResponse
    {
        $objects = $handler->handle(new GetActiveWarehouseObjectsByCitySlugQuery($citySlug));

        return response()->json([
            'success' => true,
            'data' => WarehouseObjectResource::collection($objects)
        ]);
=======
        string                                     $citySlug
    )
    {
        $objects = $handler->handle(new GetActiveWarehouseObjectsByCitySlugQuery($citySlug));
        dd($objects->toArray());
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    }

    public function show(
        GetActiveWarehouseObjectBySlugAndCitySlugHandler $handler,
<<<<<<< HEAD
        string $citySlug,
        string $objectSlug
    ): JsonResponse
=======
        string                                           $citySlug,
        string                                           $objectSlug
    )
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    {
        $object = $handler->handle(new GetActiveWarehouseObjectBySlugAndCitySlugQuery(
            slug: $objectSlug,
            citySlug: $citySlug
        ));
<<<<<<< HEAD



        return response()->json([
            'success' => true,
            'data' => new WarehouseObjectResource($object)
        ]);
    }
}
=======
        dd($object->toArray());
    }
}
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
