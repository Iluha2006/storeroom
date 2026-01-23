<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\File;
use App\Enums\UserPermissionEnum;


/** @mixin File */
class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name ?? $this->original_name,
            'original_name' => $this->original_name,
            'filename' => $this->filename,
            'extension' => $this->extension,
            'url' => $this->url,
            'path' => $this->when(
                $request->user()?->hasPermissionTo(UserPermissionEnum::FileView),
                $this->path
            ),
            'size' => [
                'bytes' => $this->size,
                'formatted' => $this->getFormattedSize(),
            ],
            'mime_type' => $this->mime_type,
            'is_image' => $this->isImage(),
            'collection' => [
                'value' => $this->collection->value,
                'label' => $this->collection->getLabel(),
            ],
            'dimensions' => $this->when($this->isImage(), [
                'width' => $this->width,
                'height' => $this->height,
            ]),
            'order' => $this->order,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function getFormattedSize(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }
}
