<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugQuery;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellBySlugQuery;
use App\Handlers\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugHandler;
use App\Handlers\Queries\WarehouseCell\GetAvailableWarehouseCellBySlugHandler;


class WarehouseCellController extends Controller
{
    public function index(
        GetAvailableWarehouseCellsBySlugHandler $handler,
        string                                  $citySlug,
        string                                  $objectSlug
    )
    {
        /** @var Collection $cells */
        $cells = $handler->handle(new GetAvailableWarehouseCellsBySlugQuery(
            citySlug: $citySlug,
            objectSlug: $objectSlug
        ));
        dd($cells->toArray());
    }

    public function show(
        GetAvailableWarehouseCellBySlugHandler $handler,
        string                                 $cellSlug
    )
    {
        $cell = $handler->handle(new GetAvailableWarehouseCellBySlugQuery(slug: $cellSlug));
        dd($cell->toArray());
    }
}
