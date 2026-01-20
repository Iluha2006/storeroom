<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatusEnum: int
{
    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return array_combine(self::cases(), self::list());
    }

    public function label(): string
    {
        return self::forForm()[$this->value];
    }
}
