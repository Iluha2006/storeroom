<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;


enum FileCollectionEnum: string implements HasLabel, HasColor, HasIcon
{
    case Files = 'files';
    case Photos = 'photos';
    case Images = 'images';
    case Videos = 'videos';
    case Audios = 'audios';
    case Documents = 'documents';
    case Archives = 'archives';
    case Reports = 'reports';
    case Plans = 'plans';
    case Certificates = 'certificates';

    public static function list(): array
    {
        return array_map(fn(self $item) => $item->value, self::cases());
    }

    public static function forForm(): array
    {
        return [
            self::Files->value => 'Файлы',
            self::Photos->value => 'Фотографии',
            self::Images->value => 'Изображения',
            self::Videos->value => 'Видео',
            self::Audios->value => 'Аудио',
            self::Documents->value => 'Документы',
            self::Archives->value => 'Архивы',
            self::Reports->value => 'Отчёты',
            self::Plans->value => 'Планы',
            self::Certificates->value => 'Сертификаты',
        ];
    }

    public function getLabel(): string
    {
        return self::forForm()[$this->value];
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Files => 'heroicon-o-folder',
            self::Photos => 'heroicon-o-camera',
            self::Images => 'heroicon-o-photo',
            self::Videos => 'heroicon-o-video-camera',
            self::Audios => 'heroicon-o-musical-note',
            self::Documents => 'heroicon-o-document-text',
            self::Archives => 'heroicon-o-archive-box',
            self::Reports => 'heroicon-o-chart-bar',
            self::Plans => 'heroicon-o-calendar',
            self::Certificates => 'heroicon-o-badge-check',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Files => Color::Blue,
            self::Photos => Color::Emerald,
            self::Images => Color::Purple,
            self::Videos => Color::Red,
            self::Audios => Color::Amber,
            self::Documents => Color::Cyan,
            self::Archives => Color::Gray,
            self::Reports => Color::Orange,
            self::Plans => Color::Indigo,
            self::Certificates => Color::Green,
        };
    }
}
