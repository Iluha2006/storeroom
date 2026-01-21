<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Required;


#[MapInputName(SnakeCaseMapper::class)]
class AddressData extends Data
{
    public function __construct(
        public ?int                $id,
        public ?string             $uuid,

        #[Required]
        public int                 $cityId,

        public bool                $isActive = false,
        public ?string             $slug,

        #[Required]
        public string              $street,

        #[Required]
        public string              $house,

        public ?string             $building,
        public ?string             $frame,
        public ?float              $lat,
        public ?float              $lon,
        public ?string             $howToGetThere,

        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?\DateTimeImmutable $deletedAt = null,
    )
    {
    }

    public function getFullAddress(): string
    {
        $parts = [
            $this->street,
            $this->house ? "д. {$this->house}" : null,
            $this->building ? "стр. {$this->building}" : null,
            $this->frame ? "корп. {$this->frame}" : null,
        ];

        return implode(', ', array_filter($parts));
    }

    public function hasCoordinates(): bool
    {
        return $this->lat !== null && $this->lon !== null;
    }
}
