<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Required;
use App\Enums\FileCollectionEnum;
use App\Enums\FilesystemDiskEnum;


#[MapInputName(SnakeCaseMapper::class)]
class FileData extends Data
{
    public function __construct(
        public ?int                $id,
        public ?string             $uuid,
        public string              $hash,

        #[Required]
        public FilesystemDiskEnum  $disk,

        #[Required]
        public string              $path,

        public string              $name,

        #[Required]
        public string              $filename,

        #[Required]
        public string              $originalName,

        public ?string             $extension,
        public ?string             $mimeType,
        public ?int                $size,
        public ?int                $width,
        public ?int                $height,
        public int                 $order = 0,
        public ?string             $fileableType,
        public ?int                $fileableId,

        #[Required]
        public FileCollectionEnum  $collection,

        public ?array              $metadata,

        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?\DateTimeImmutable $deletedAt = null,
    )
    {
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mimeType ?? '', 'image/');
    }

    public function getFormattedSize(): string
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
