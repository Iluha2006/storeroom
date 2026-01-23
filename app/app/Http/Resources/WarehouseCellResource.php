<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\WarehouseCell;


/** @mixin WarehouseCell */
class WarehouseCellResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->getLabel(),
            ],
            'position' => [
                'floor' => $this->floor,
                'row' => $this->row,
                'section' => $this->section,
                'level' => $this->level,
                'number' => $this->number,
                'formatted' => $this->getFormattedPosition(),
            ],
            'dimensions' => [
                'length' => $this->length,
                'height' => $this->height,
                'width' => $this->width,
                'volume_cm3' => $this->volume,
                'volume_m3' => $this->volume_cubic_meters,
            ],
            'price' => [
                'amount' => $this->price,
                'formatted' => $this->formatted_price,
            ],
            'how_to_get_there' => $this->how_to_get_there,
            'files' => [
                'plan' => $this->when(
                    $this->relationLoaded('files'),
                    fn() => $this->plan ? new FileResource($this->plan) : null
                ),
                'photos' => $this->when(
                    $this->relationLoaded('files'),
                    fn() => FileResource::collection($this->photos)
                ),
                'counts' => [
                    'total' => $this->whenLoaded('files', fn() => $this->files->count(), 0),
                    'photos' => $this->whenLoaded('files', fn() => $this->photos->count(), 0),
                ],
            ],
            'object' => new WarehouseObjectResource($this->whenLoaded('object')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function getFormattedPosition(): string
    {
        return sprintf(
            'Этаж %d, ряд %d, секция %d, уровень %d, #%d',
            $this->floor,
            $this->row,
            $this->section,
            $this->level,
            $this->number
        );
    }
}
