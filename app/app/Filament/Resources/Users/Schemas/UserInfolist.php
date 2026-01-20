<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;


class UserInfolist
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

                        TextEntry::make('name')
                            ->label('Имя')
                            ->weight('bold'),

                        TextEntry::make('lastname')
                            ->label('Фамилия')
                            ->placeholder('Не указано')
                            ->weight('bold'),

                        TextEntry::make('email')
                            ->label('E-mail')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('E-mail скопирован'),

                        TextEntry::make('phone')
                            ->label('Телефон')
                            ->placeholder('Не указано')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Телефон скопирован'),

                        TextEntry::make('organization.name')
                            ->label('Организация')
                            ->placeholder('Не указано')
                            ->copyable()
                            ->copyMessage('Организация скопирована'),
                    ])
                    ->columns(3),
                Section::make('Безопасность')
                    ->schema([
                        TextEntry::make('email_verified_at')
                            ->label('E-mail подтвержден')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('phone_verified_at')
                            ->label('Телефон подтвержден')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(2),
                Section::make('Системная информация')
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),

                        TextEntry::make('uuid')
                            ->label('UUID для API'),
                    ])
                    ->columns(2),
                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Создано')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Обновлено')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('last_login_at')
                            ->label('Последняя авторизация')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(3),
            ]);
    }
}
