<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\FilesystemDiskEnum;
use App\Enums\FileCollectionEnum;


class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash',
        'disk',
        'path',
        'name',
        'filename',
        'original_name',
        'extension',
        'mime_type',
        'size',
        'width',
        'height',
        'order',
        'fileable_type',
        'fileable_id',
        'collection',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'hash' => 'string',
            'disk' => FilesystemDiskEnum::class,
            'path' => 'string',
            'name' => 'string',
            'filename' => 'string',
            'original_name' => 'string',
            'extension' => 'string',
            'mime_type' => 'string',
            'size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'order' => 'integer',
            'fileable_type' => 'string',
            'fileable_id' => 'integer',
            'collection' => FileCollectionEnum::class,
            'metadata' => 'array',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
        ];
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeCollection($query, string $collection)
    {
        return $query->where('collection', $collection);
    }

    public function scopeImages($query)
    {
        return $query->where('mime_type', 'LIKE', 'image/%');
    }

    public function scopeDocuments($query)
    {
        return $query->whereIn('mime_type', [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }
}
