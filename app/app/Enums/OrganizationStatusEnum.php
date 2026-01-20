<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Illuminate\Contracts\Support\Htmlable;

enum OrganizationStatusEnum: int implements HasLabel, HasColor, HasIcon
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
            self::Active->value => 'Договор подписан',
            self::Inactive->value => 'Договор не подписан',
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
            self::Inactive => 'warning',
            self::Blocked => 'gray',
        };
    }

    public function getIcon(): string | null | \BackedEnum | Htmlable
    {
        return match ($this) {
            self::Active => 'heroicon-o-check-circle',
            self::Inactive => 'heroicon-o-minus-circle',
            self::Blocked => 'heroicon-o-pause-circle',
        };
    }
}
