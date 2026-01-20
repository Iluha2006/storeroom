<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum WarehouseCellStatusEnum: int implements HasLabel, HasColor, HasIcon
{
    case Available = 10;
    case Reserved = 9;
    case Unavailable = 8;

    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return [
            self::Available->value => 'Доступно',
            self::Reserved->value => 'Зарезервировано',
            self::Unavailable->value => 'Недоступно',
        ];
    }

    public function getLabel(): string
    {
        return self::forForm()[$this->value];
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Available => 'success',
            self::Reserved => 'gray',
            self::Unavailable => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Available => 'heroicon-o-check-circle',
            self::Reserved => 'heroicon-o-pause-circle',
            self::Unavailable => 'heroicon-o-minus-circle',
        };
    }
}
