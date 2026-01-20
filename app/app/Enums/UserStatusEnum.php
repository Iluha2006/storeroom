<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum UserStatusEnum: int implements HasLabel, HasColor, HasIcon
{
    case Active = 10;
    case Inactive = 9;
    case Blocked = 8;

    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return [
            self::Active->value => 'Активен',
            self::Inactive->value => 'Неактивен',
            self::Blocked->value => 'Заблокирован',
        ];
    }

    public function getLabel(): string
    {
        return self::forForm()[$this->value];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Blocked => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active => 'heroicon-o-check-circle',
            self::Inactive => 'heroicon-o-minus-circle',
            self::Blocked => 'heroicon-o-pause-circle',
        };
    }
}
