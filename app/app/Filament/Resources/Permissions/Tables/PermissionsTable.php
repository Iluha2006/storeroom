<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use App\Enums\UserPermissionEnum;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use App\Enums\UserRoleEnum;

class PermissionsTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Название')
                    ->formatStateUsing(fn(string $state) => UserPermissionEnum::tryFrom($state)?->label() ?? $state)
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn(Permission $record): string => 'Используется в ' . $record->roles()->count() . ' ролях'),

                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge()
                    ->sortable(),

                TextColumn::make('roles.name')
                    ->label('Роли')
                    ->badge()
                    ->searchable()
                    ->limit(3)
                    ->tooltip(fn(Permission $record): ?string => $record->roles()->count() > 3
                        ? 'И еще ' . ($record->roles()->count() - 3) . ' ролей'
                        : null
                    ),

                TextColumn::make('roles_count')
                    ->label('Ролей')
                    ->counts('roles')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('users_count')
                    ->label('Прямых пользователей')
                    ->counts('users')
                    ->sortable()
                    ->badge()
                    ->color('warning')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('guard_name')
                    ->label('Guard')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ])
                    ->native(false),

                SelectFilter::make('roles')
                    ->label('Роль')
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn($record) => UserRoleEnum::tryFrom($record->name)?->label() ?? $record->name)
                    ->multiple()
                    ->preload()
                    ->native(false),

                Filter::make('has_roles')
                    ->label('С ролями')
                    ->query(fn($query) => $query->has('roles')),

                Filter::make('no_roles')
                    ->label('Без ролей')
                    ->query(fn($query) => $query->doesntHave('roles')),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
