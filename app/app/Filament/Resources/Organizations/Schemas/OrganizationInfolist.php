<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Models\Organization;


class OrganizationInfolist
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

                        TextEntry::make('type')
                            ->label('Тип')
                            ->badge(),

                        TextEntry::make('name')
                            ->label('Название'),

                        TextEntry::make('full_name')
                            ->label('Полное наименование')
                            ->placeholder('Не указано'),
                    ])
                    ->columns(2),

                Section::make('Реквизиты')
                    ->schema([
                        TextEntry::make('inn')
                            ->label('ИНН')
                            ->placeholder('Не указан')
                            ->copyable()
                            ->copyMessage('ИНН скопирован'),

                        TextEntry::make('kpp')
                            ->label('КПП')
                            ->placeholder('Не указан')
                            ->copyable()
                            ->copyMessage('КПП скопирован'),

                        TextEntry::make('ogrn')
                            ->label('ОГРН/ОГРНИП')
                            ->placeholder('Не указан')
                            ->copyable()
                            ->copyMessage('ОГРН скопирован'),
                    ])
                    ->columns(3),

                Section::make('Контакты')
                    ->schema([
                        TextEntry::make('address')
                            ->label('Адрес')
                            ->placeholder('Не указан')
                            ->columnSpanFull(),

                        TextEntry::make('phone')
                            ->label('Телефон')
                            ->placeholder('Не указан')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Телефон скопирован'),

                        TextEntry::make('email')
                            ->label('E-mail')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('E-mail скопирован'),
                    ])
                    ->columns(2),

                Section::make('Дополнительно')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Создана')
                            ->dateTime('d.m.Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Обновлена')
                            ->dateTime('d.m.Y H:i'),

                        TextEntry::make('users_count')
                            ->label('Пользователей')
                            ->state(fn(Organization $record): string => $record->users()->count())
                            ->badge()
                            ->color('info'),
                    ])
                    ->columns(3)
                    ->collapsed(),
            ]);
    }
}
