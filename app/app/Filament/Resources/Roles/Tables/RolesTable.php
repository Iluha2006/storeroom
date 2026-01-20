<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use App\Enums\UserRoleEnum;


class RolesTable
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
                    ->formatStateUsing(fn(string $state) => UserRoleEnum::tryFrom($state)?->label() ?? $state)
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color(fn(string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin' => 'warning',
                        'moderator' => 'success',
                        default => 'primary',
                    }),

                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge()
                    ->sortable(),

                TextColumn::make('permissions_count')
                    ->label('Разрешений')
                    ->counts('permissions')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('users_count')
                    ->label('Пользователей')
                    ->counts('users')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновлена')
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

                Filter::make('has_users')
                    ->label('С пользователями')
                    ->query(fn($query) => $query->has('users')),

                Filter::make('no_users')
                    ->label('Без пользователей')
                    ->query(fn($query) => $query->doesntHave('users')),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
