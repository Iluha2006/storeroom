<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseCellRequest;
use App\Http\Resources\WarehouseCellResource;
use App\Models\WarehouseCell;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WarehouseCellController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', WarehouseCell::class);

        return WarehouseCellResource::collection(WarehouseCell::all());
    }

    public function store(WarehouseCellRequest $request)
    {
        $this->authorize('create', WarehouseCell::class);

        return new WarehouseCellResource(WarehouseCell::create($request->validated()));
    }

    public function show(WarehouseCell $warehouseCell)
    {
        $this->authorize('view', $warehouseCell);

        return new WarehouseCellResource($warehouseCell);
    }

    public function update(WarehouseCellRequest $request, WarehouseCell $warehouseCell)
    {
        $this->authorize('update', $warehouseCell);

        $warehouseCell->update($request->validated());

        return new WarehouseCellResource($warehouseCell);
    }

    public function destroy(WarehouseCell $warehouseCell)
    {
        $this->authorize('delete', $warehouseCell);

        $warehouseCell->delete();

        return response()->json();
    }
}
