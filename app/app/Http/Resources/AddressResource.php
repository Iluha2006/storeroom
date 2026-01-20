<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin Address */
class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'city_id' => $this->city_id,
            'is_active' => $this->is_active,
            'slug' => $this->slug,
            'street' => $this->street,
            'house' => $this->house,
            'building' => $this->building,
            'frame' => $this->frame,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'how_to_get_there' => $this->how_to_get_there,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}
