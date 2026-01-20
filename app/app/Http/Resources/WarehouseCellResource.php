<?php

namespace App\Http\Resources;

use App\Models\WarehouseCell;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin WarehouseCell */
class WarehouseCellResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'warehouse_object_id' => $this->warehouse_object_id,
            'status' => $this->status,
            'slug' => $this->slug,
            'floor' => $this->floor,
            'row' => $this->row,
            'section' => $this->section,
            'level' => $this->level,
            'number' => $this->number,
            'length' => $this->length,
            'height' => $this->height,
            'width' => $this->width,
            'volume' => $this->volume,
            'price' => $this->price,
            'how_to_get_there' => $this->how_to_get_there,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'object' => new WarehouseObjectResource($this->whenLoaded('object')),
        ];
    }
}
