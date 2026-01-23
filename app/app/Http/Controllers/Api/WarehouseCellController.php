<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\WarehouseCellResource;
use App\Http\Controllers\ApiController;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugQuery;
use App\Queries\WarehouseCell\GetAvailableWarehouseCellBySlugQuery;
use App\Handlers\Queries\WarehouseCell\GetAvailableWarehouseCellsBySlugHandler;
use App\Handlers\Queries\WarehouseCell\GetAvailableWarehouseCellBySlugHandler;


class WarehouseCellController extends ApiController
{
    use AuthorizesRequests;

    public function index(
        GetAvailableWarehouseCellsBySlugHandler $handler,
        string                                  $citySlug,
        string                                  $objectSlug
    )
    {
        $cells = $handler->handle(new GetAvailableWarehouseCellsBySlugQuery(
            citySlug: $citySlug,
            objectSlug: $objectSlug
        ));

        if ($cells->isEmpty()) {
            return $this->error('Cells not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(WarehouseCellResource::collection($cells));
    }

    public function show(
        GetAvailableWarehouseCellBySlugHandler $handler,
        string                                 $cellSlug
    )
    {
        $cell = $handler->handle(new GetAvailableWarehouseCellBySlugQuery(slug: $cellSlug));

        if (!$cell) {
            return $this->error('Cell not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(new WarehouseCellResource($cell));
    }
}
