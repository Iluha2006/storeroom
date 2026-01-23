<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Address;


/** @mixin Address */
class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'is_active' => $this->is_active,
            'slug' => $this->slug,
            'street' => $this->street,
            'house' => $this->house,
            'building' => $this->building,
            'frame' => $this->frame,
            'full_address' => $this->full_address,
            'how_to_get_there' => $this->how_to_get_there,
            'coordinates' => [
                'lat' => $this->lat,
                'lon' => $this->lon,
            ],
            'city' => new CityResource($this->whenLoaded('city')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
