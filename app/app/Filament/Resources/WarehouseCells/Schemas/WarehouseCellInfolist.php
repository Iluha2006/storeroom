<?php

namespace App\Filament\Resources\WarehouseCells\Schemas;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class WarehouseCellInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Статус')
                            ->badge(),

                        TextEntry::make('object.name')
                            ->label('Объект'),

                        TextEntry::make('number')
                            ->label('Номер ячейки'),

                        TextEntry::make('price')
                            ->label('Цена'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Параметры')
                    ->schema([
                        TextEntry::make('floor')
                            ->label('Этаж'),

                        TextEntry::make('row')
                            ->label('Ряд'),

                        TextEntry::make('section')
                            ->label('Секция'),

                        TextEntry::make('level')
                            ->label('Уровень'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Габариты')
                    ->schema([
                        TextEntry::make('length')
                            ->label('Длинна, см'),

                        TextEntry::make('height')
                            ->label('Высота, см'),

                        TextEntry::make('width')
                            ->label('Ширина, см'),

                        TextEntry::make('volume')
                            ->label('Объем, см³'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('План помещения')
                    ->schema([
                        ImageEntry::make('plan')
                            ->label('')
                            ->getStateUsing(fn($record) => $record->plan?->url)
                            ->imageHeight(400)
                            ->hiddenLabel()
                            ->visible(fn($record) => $record->plan !== null),

                        TextEntry::make('plan_info')
                            ->label('')
                            ->getStateUsing(fn($record) => $record->plan
                                ? "Файл: {$record->plan->original_name} (" . number_format($record->plan->size / 1024, 2) ." KB)"
                                : 'План помещения не загружен'
                            )
                            ->hiddenLabel(),

                        Actions::make([
                            Action::make('download_plan')
                                ->label('Скачать план')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->url(fn($record) => $record->plan?->url, shouldOpenInNewTab: true)
                                ->visible(fn($record) => $record->plan !== null),
                        ]),
                    ])
                    ->collapsible(),

                Section::make('Фотографии')
                    ->schema([
                        RepeatableEntry::make('photos')
                            ->label('')
                            ->schema([
                                ImageEntry::make('url')
                                    ->label('')
                                    ->imageHeight(200)
                                    ->hiddenLabel(),

                                TextEntry::make('original_name')
                                    ->label('Название файла')
                                    ->size('sm'),

                                TextEntry::make('size')
                                    ->label('Размер')
                                    ->formatStateUsing(fn ($state) => number_format($state / 1024, 2) . ' KB')
                                    ->size('sm'),

                                Actions::make([
                                    Action::make('download')
                                        ->label('Скачать')
                                        ->icon('heroicon-o-arrow-down-tray')
                                        ->url(fn ($record) => $record->url, shouldOpenInNewTab: true)
                                        ->size('sm'),
                                ]),
                            ])
                            ->columns(2)
                            ->hiddenLabel()
                            ->visible(fn ($record) => $record->photos->isNotEmpty()),

                        TextEntry::make('photos_empty')
                            ->label('')
                            ->default('Фотографии не загружены')
                            ->hiddenLabel()
                            ->visible(fn ($record) => $record->photos->isEmpty()),
                    ])
                    ->collapsible(),

                Section::make('Информация')
                    ->schema([
                        TextEntry::make('slug')
                            ->label('Символьный код'),

                        TextEntry::make('how_to_get_there')
                            ->label('Как добраться')
                            ->html(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),

                        TextEntry::make('uuid')
                            ->label('UUID'),

                        TextEntry::make('created_at')
                            ->label('Создан')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Обновлен')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
