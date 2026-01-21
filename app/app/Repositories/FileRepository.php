<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\File;
use App\Enums\FileCollectionEnum;


class FileRepository extends BaseRepository
{
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function findByHash(string $hash): File | Model | null
    {
        return $this->newQuery()
            ->where('hash', $hash)
            ->first();
    }

    public function findByFileable(string $fileableType, int $fileableId): Collection
    {
        return $this->newQuery()
            ->where('fileable_type', $fileableType)
            ->where('fileable_id', $fileableId)
            ->orderBy('order')
            ->get();
    }

    public function findByCollection(FileCollectionEnum $collection): Collection
    {
        return $this->newQuery()
            ->where('collection', $collection)
            ->get();
    }

    public function findImages(): Collection
    {
        return $this->newQuery()
            ->images()
            ->get();
    }

    public function findDocuments(): Collection
    {
        return $this->newQuery()
            ->documents()
            ->get();
    }

    public function findByFileableAndCollection(
        string             $fileableType,
        int                $fileableId,
        FileCollectionEnum $collection
    ): Collection
    {
        return $this->newQuery()
            ->where('fileable_type', $fileableType)
            ->where('fileable_id', $fileableId)
            ->where('collection', $collection)
            ->orderBy('order')
            ->get();
    }

    public function deleteByFileable(string $fileableType, int $fileableId): bool
    {
        return $this->newQuery()
            ->where('fileable_type', $fileableType)
            ->where('fileable_id', $fileableId)
            ->delete();
    }
}
