<?php

namespace App\Filament\Resources\Cities\RelationManagers;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\RelationManagers\RelationManager;
use App\Enums\UserPermissionEnum;


class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $title = 'Адресы';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can(UserPermissionEnum::AddressView->value);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('uuid')
                    ->label('UUID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->label('Активен')
                    ->sortable()
                    ->boolean(),

                TextColumn::make('slug')
                    ->label('Символьный код')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('street')
                    ->label('Улица')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('house')
                    ->label('Дом')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('building')
                    ->label('Строение')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('frame')
                    ->label('Корпус')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('lat')
                    ->label('Широта')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('lon')
                    ->label('Долгота')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->emptyStateHeading('Нет адресов')
            ->emptyStateIcon('heroicon-o-map-pin');
    }
}
