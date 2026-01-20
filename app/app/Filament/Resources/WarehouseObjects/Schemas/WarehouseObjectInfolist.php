<?php

namespace App\Filament\Resources\WarehouseObjects\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;

class WarehouseObjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Активен')
                            ->boolean(),

                        TextEntry::make('address.full_address')
                            ->label('Адрес')
                            ->weight('bold'),

                        TextEntry::make('organization.name')
                            ->label('Организация')
                            ->weight('bold'),
                    ])
                    ->columns(3),

                Section::make('Информация')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Название')
                            ->weight('bold'),

                        TextEntry::make('slug')
                            ->label('Символьный код'),

                        TextEntry::make('description')
                            ->label('Описание')
                            ->html(),
                    ])
                    ->columns(1),

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
