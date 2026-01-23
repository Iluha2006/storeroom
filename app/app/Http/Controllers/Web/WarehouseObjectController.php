<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugQuery;
use App\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugQuery;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectBySlugAndCitySlugHandler;
use App\Handlers\Queries\WarehouseObject\GetActiveWarehouseObjectsByCitySlugHandler;


class WarehouseObjectController extends Controller
{
    public function index(
        GetActiveWarehouseObjectsByCitySlugHandler $handler,
        string                                     $citySlug
    )
    {
        $objects = $handler->handle(new GetActiveWarehouseObjectsByCitySlugQuery($citySlug));
        dd($objects->toArray());
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
        dd($object->toArray());
    }
}
