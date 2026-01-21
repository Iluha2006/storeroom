<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use App\Enums\UserStatusEnum;


#[MapInputName(SnakeCaseMapper::class)]
class UserData extends Data
{
    public function __construct(
        public ?int                $id,
        public ?string             $uuid,
        public ?int                $organizationId,

        #[Required]
        public UserStatusEnum      $status,

        #[Required]
        public string              $name,

        public ?string             $lastname,

        #[Required, Email]
        public string              $email,
        public ?\DateTimeImmutable $emailVerifiedAt = null,

        public ?string             $phone,
        public ?\DateTimeImmutable $phoneVerifiedAt = null,
        public ?\DateTimeImmutable $lastLoginAt = null,

        public ?\DateTimeImmutable $createdAt = null,
        public ?\DateTimeImmutable $updatedAt = null,
        public ?\DateTimeImmutable $deletedAt = null,
    )
    {
    }

    public function getFullName(): string
    {
        return trim("{$this->name} {$this->lastname}");
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerifiedAt !== null;
    }

    public function isPhoneVerified(): bool
    {
        return $this->phoneVerifiedAt !== null;
    }
}
