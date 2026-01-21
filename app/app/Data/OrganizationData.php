<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use App\Enums\OrganizationTypeEnum;
use App\Enums\OrganizationStatusEnum;


#[MapInputName(SnakeCaseMapper::class)]
class OrganizationData extends Data
{
    public function __construct(
        public ?int                   $id,
        public ?string                $uuid,

        #[Required]
        public OrganizationStatusEnum $status,

        #[Required]
        public OrganizationTypeEnum   $type,

        #[Required]
        public string                 $name,

        public ?string                $fullName,

        public ?string                $inn,
        public ?string                $kpp,
        public ?string                $ogrn,
        public ?string                $address,
        public ?string                $phone,

        #[Email]
        public ?string                $email,

        public ?\DateTimeImmutable    $createdAt = null,
        public ?\DateTimeImmutable    $updatedAt = null,
        public ?\DateTimeImmutable    $deletedAt = null,
    )
    {
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function getFullDisplayName(): string
    {
        return $this->fullName ?: $this->name;
    }
}
