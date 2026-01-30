<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\WarehouseObject;


/** @mixin WarehouseObject */
class WarehouseObjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'is_active' => $this->is_active,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'address' => new AddressResource($this->whenLoaded('address')),
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
            'cells_count' => $this->available_cells_count,
'price' => $this->price,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
