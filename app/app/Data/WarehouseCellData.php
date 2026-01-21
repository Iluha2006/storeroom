<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use App\Enums\WarehouseCellStatusEnum;


#[MapInputName(SnakeCaseMapper::class)]
class WarehouseCellData extends Data
{
    public function __construct(
        public ?int                    $id,
        public ?string                 $uuid,

        #[Required]
        public int                     $warehouseObjectId,

        #[Required]
        public WarehouseCellStatusEnum $status,

        public ?string                 $slug,

        #[Min(0)]
        public int                     $floor,

        #[Min(1)]
        public int                     $row,

        #[Min(1)]
        public int                     $section,

        #[Min(1)]
        public int                     $level,

        #[Required, Min(1)]
        public int                     $number,

        #[Required, Min(1)]
        public int                     $length,

        #[Required, Min(1)]
        public int                     $height,

        #[Required, Min(1)]
        public int                     $width,

        #[Min(0)]
        public ?int                    $volume,

        #[Required, Min(0)]
        public float                   $price,

        public ?string                 $howToGetThere,

        public ?\DateTimeImmutable     $createdAt = null,
        public ?\DateTimeImmutable     $updatedAt = null,
        public ?\DateTimeImmutable     $deletedAt = null,
    )
    {
        $this->volume = $this->length * $this->height * $this->width;
    }

    public function getVolumeCubicMeters(): float
    {
        return round($this->volume / 1000000, 2);
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 2, ',', ' ') . ' ₽';
    }
}
