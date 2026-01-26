<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Queries\City\GetActiveCitiesQuery;
use App\Handlers\Queries\City\GetActiveCitiesHandler;
use App\Handlers\Queries\City\GetActiveCityBySlugHandler;
use App\Queries\City\GetCityBySlugQuery;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    public function index(
        GetActiveCitiesHandler $handler
    ): JsonResponse
    {
        $cities = $handler->handle(new GetActiveCitiesQuery());

        return response()->json([
            'success' => true,
            'data' => CityResource::collection($cities)
        ]);
    }

    public function show(
        GetActiveCityBySlugHandler $handler,
        string $slug
    ): JsonResponse
    {
        $city = $handler->handle(new GetCityBySlugQuery($slug));
        if (!$city) {
            return response()->json([
                'success' => false,
                'message' => 'City not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'arrayData' => new CityResource($city)
        ]);
    }
}