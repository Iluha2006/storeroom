<?php

namespace App\Http\Resources;

use App\Models\WarehouseObject;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin WarehouseObject */
class WarehouseObjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'address_id' => $this->address_id,
            'organization_id' => $this->organization_id,
            'is_active' => $this->is_active,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'address' => new AddressResource($this->whenLoaded('address')),
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
        ];
    }
}
