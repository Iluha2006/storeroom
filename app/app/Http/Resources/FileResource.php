<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\File;


/** @mixin File */
class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name ?? $this->original_name,
            'url' => $this->url,
            'path' => $this->path,
            'size' => $this->size,
            'mime_type' => $this->mime_type,
            'extension' => $this->extension,
            'collection' => $this->collection,
            'order' => $this->order,
            'dimensions' => $this->when($this->isImage(), [
                'width' => $this->width,
                'height' => $this->height,
            ]),
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
        ];
    }
}
