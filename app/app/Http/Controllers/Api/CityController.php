<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\CityResource;
use App\Http\Controllers\ApiController;
use App\Queries\City\GetCityBySlugQuery;
use App\Queries\City\GetActiveCitiesQuery;
use App\Handlers\Queries\City\GetActiveCitiesHandler;
use App\Handlers\Queries\City\GetActiveCityBySlugHandler;


class CityController extends ApiController
{
    use AuthorizesRequests;

    public function index(GetActiveCitiesHandler $handler)
    {
        $cities = $handler->handle(new GetActiveCitiesQuery());

        if ($cities->isEmpty()) {
            return $this->error('Cities not found', Response::HTTP_NOT_FOUND);
        }

        return $this->success(CityResource::collection($cities));
    }

    public function show(GetActiveCityBySlugHandler $handler,string $slug)
    {
        $city = $handler->handle(new GetCityBySlugQuery($slug));
        if (!$city) {
            return $this->error('City not found', Response::HTTP_NOT_FOUND);
        }
        return $this->success(new CityResource($city));
    }
}
