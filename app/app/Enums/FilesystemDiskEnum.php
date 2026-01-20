<?php

declare(strict_types=1);

namespace App\Enums;

enum FilesystemDiskEnum: string
{
    case Local = 'local';
    case Public = 'public';
    case S3 = 's3';

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
