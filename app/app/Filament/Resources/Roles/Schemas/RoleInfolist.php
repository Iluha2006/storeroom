<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use App\Enums\UserRoleEnum;
use Filament\Schemas\Components\Section;
use App\Enums\UserPermissionEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Название')
                            ->formatStateUsing(fn($state) => UserRoleEnum::tryFrom($state)?->label() ?? $state)
                            ->weight('bold'),

                        TextEntry::make('guard_name')
                            ->label('Guard')
                            ->badge(),
                    ])
                    ->columns(2),

                Section::make('Дополнительная информация')
                    ->schema([
                        TextEntry::make('permissions_count')
                            ->label('Количество разрешений')
                            ->state(fn(?Role $record): string => $record ? $record->permissions()->count() : '0'),

                        TextEntry::make('users_count')
                            ->label('Прямых пользователей')
                            ->state(fn(?Role $record): string => $record ? $record->users()->count() : '0'),

                        TextEntry::make('created_at')
                            ->label('Создана')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Обновлена')
                            ->dateTime('d.m.Y H:i:s'),
                    ])
                    ->columns(2)
                    ->hiddenOn('create')
                    ->collapsible(),
            ]);
    }
}
