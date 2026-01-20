<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\CheckboxList;
use App\Enums\UserRoleEnum;
use Filament\Tables\Columns\TextColumn;
use Spatie\Permission\Models\Permission;
use App\Enums\UserPermissionEnum;

class PermissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Название')
                            ->formatStateUsing(fn($state) => UserPermissionEnum::tryFrom($state)?->label() ?? $state)
                            ->weight('bold'),

                        TextEntry::make('guard_name')
                            ->label('Guard')
                            ->badge(),
                    ])
                    ->columns(2),

                Section::make('Роли')
                    ->schema([
                        TextEntry::make('roles.name')
                            ->label('Роли')
                            ->formatStateUsing(fn($state) => UserRoleEnum::tryFrom($state)?->label() ?? $state)
                            ->badge(),
                    ]),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('roles_count')
                            ->label('Количество ролей')
                            ->state(fn(?Permission $record): string => $record ? $record->roles()->count() : '0'),

                        TextEntry::make('users_count')
                            ->label('Прямых пользователей')
                            ->state(fn(?Permission $record): string => $record ? $record->users()->count() : '0'),

                        TextEntry::make('created_at')
                            ->label('Создано')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Обновлено')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
