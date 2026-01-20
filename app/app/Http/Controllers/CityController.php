<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CityController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', City::class);

        return CityResource::collection(City::all());
    }

    public function store(CityRequest $request)
    {
        $this->authorize('create', City::class);

        return new CityResource(City::create($request->validated()));
    }

    public function show(City $city)
    {
        $this->authorize('view', $city);

        return new CityResource($city);
    }

    public function update(CityRequest $request, City $city)
    {
        $this->authorize('update', $city);

        $city->update($request->validated());

        return new CityResource($city);
    }

    public function destroy(City $city)
    {
        $this->authorize('delete', $city);

        $city->delete();

        return response()->json();
    }
}
