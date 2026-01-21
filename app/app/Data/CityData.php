<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Required;


#[MapInputName(SnakeCaseMapper::class)]
class CityData extends Data
{
    public function __construct(
        public ?int                $id,
        public ?string             $uuid,
        public bool                $isActive = false,

        #[Required]
        public string              $name,

        public ?string             $slug,

        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?\DateTimeImmutable $deletedAt = null,
    )
    {
    }
}
