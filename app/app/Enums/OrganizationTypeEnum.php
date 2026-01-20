<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum OrganizationTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case Legal = 'legal';
    case Individual = 'individual';

    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return [
            self::Legal->value => 'Юр. лицо',
            self::Individual->value => 'ИП',
        ];
    }

    public function getLabel(): string
    {
        return self::forForm()[$this->value];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Legal => 'primary',
            self::Individual => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Legal => 'heroicon-o-building-office',
            self::Individual => 'heroicon-o-user',
        };
    }
}
