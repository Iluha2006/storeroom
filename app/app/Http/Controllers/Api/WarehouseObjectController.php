<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\WarehouseObjectResource;
use App\Http\Controllers\ApiController;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugQuery;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugQuery;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugHandler;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugHandler;


class WarehouseObjectController extends ApiController
{
    use AuthorizesRequests;

    public function index(
        GetActiveWarehouseObjectsByCitySlugHandler $handler,
        string                                     $citySlug
    )
    {
        $objects = $handler->handle(new GetActiveWarehouseObjectsByCitySlugQuery($citySlug));

        if ($objects->isEmpty()) {
            return $this->error('Objects not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(WarehouseObjectResource::collection($objects));
    }

    public function show(
        GetActiveWarehouseObjectBySlugAndCitySlugHandler $handler,
        string                                           $citySlug,
        string                                           $objectSlug
    )
    {
        $object = $handler->handle(new GetActiveWarehouseObjectBySlugAndCitySlugQuery(
            slug: $objectSlug,
            citySlug: $citySlug
        ));

        if (!$object) {
            return $this->error('Object not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(new WarehouseObjectResource($object));
    }
}
