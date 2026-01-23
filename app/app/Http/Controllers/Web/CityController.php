<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Queries\City\GetCityBySlugQuery;
use App\Queries\City\GetActiveCitiesQuery;
use App\Handlers\Queries\City\GetActiveCitiesHandler;
use App\Handlers\Queries\City\GetActiveCityBySlugHandler;


class CityController extends Controller
{
    public function index(
        GetActiveCitiesHandler $handler
    )
    {
        $cities = $handler->handle(new GetActiveCitiesQuery());
        dd($cities->toArray());
    }

    public function show(
        GetActiveCityBySlugHandler $handler,
        string                     $slug
    )
    {
        $city = $handler->handle(new GetCityBySlugQuery($slug));
        dd($city->toArray());
    }
}
