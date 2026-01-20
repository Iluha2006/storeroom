<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseObjectRequest;
use App\Http\Resources\WarehouseObjectResource;
use App\Models\WarehouseObject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WarehouseObjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', WarehouseObject::class);

        return WarehouseObjectResource::collection(WarehouseObject::all());
    }

    public function store(WarehouseObjectRequest $request)
    {
        $this->authorize('create', WarehouseObject::class);

        return new WarehouseObjectResource(WarehouseObject::create($request->validated()));
    }

    public function show(WarehouseObject $warehouseObject)
    {
        $this->authorize('view', $warehouseObject);

        return new WarehouseObjectResource($warehouseObject);
    }

    public function update(WarehouseObjectRequest $request, WarehouseObject $warehouseObject)
    {
        $this->authorize('update', $warehouseObject);

        $warehouseObject->update($request->validated());

        return new WarehouseObjectResource($warehouseObject);
    }

    public function destroy(WarehouseObject $warehouseObject)
    {
        $this->authorize('delete', $warehouseObject);

        $warehouseObject->delete();

        return response()->json();
    }
}
