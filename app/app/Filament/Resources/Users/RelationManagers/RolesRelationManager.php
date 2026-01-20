<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserRoleEnum;
use App\Enums\UserPermissionEnum;


class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $title = 'Роли пользователя';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can(UserPermissionEnum::UserRoleView->value);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('name')
                    ->label('Название роли')
                    ->options(UserRoleEnum::forForm())
                    ->required()
                    ->native(false),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Название')
                    ->formatStateUsing(fn(string $state) => UserRoleEnum::tryFrom($state)?->label() ?? $state)
                    ->weight('bold')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        UserRoleEnum::Superuser->value => 'danger',
                        UserRoleEnum::Developer->value => 'warning',
                        UserRoleEnum::Admin->value => 'success',
                        UserRoleEnum::Moderator->value => 'info',
                        default => 'primary',
                    }),

                TextEntry::make('guard_name')
                    ->label('Guard'),

                TextEntry::make('permissions_count')
                    ->label('Разрешений')
                    ->counts('permissions')
                    ->badge()
                    ->color('info'),

                TextEntry::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i:s'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Название')
                    ->formatStateUsing(fn(string $state) => UserRoleEnum::tryFrom($state)?->label() ?? $state)
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        UserRoleEnum::Superuser->value => 'danger',
                        UserRoleEnum::Developer->value => 'warning',
                        UserRoleEnum::Admin->value => 'success',
                        UserRoleEnum::Moderator->value => 'info',
                        default => 'primary',
                    }),

                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge(),

                TextColumn::make('permissions_count')
                    ->label('Разрешений')
                    ->counts('permissions')
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->label('Назначить роль')
                    ->recordSelectOptionsQuery(fn($query) => $query->orderBy('name'))
                    ->recordTitle(fn($record) => UserRoleEnum::tryFrom($record->name)?->label() ?? $record->name)
                    ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleEdit->value)),
            ])
            ->recordActions([
                DetachAction::make()
                    ->label('Отозвать')
                    ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleDelete->value)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->label('Отозвать выбранные')
                        ->visible(fn() => auth()->user()->can(UserPermissionEnum::UserRoleDelete->value)),
                ]),
            ]);
    }
}
