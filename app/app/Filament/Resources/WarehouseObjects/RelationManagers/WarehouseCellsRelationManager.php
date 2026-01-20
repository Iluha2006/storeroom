<?php

namespace App\Filament\Resources\WarehouseObjects\RelationManagers;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserPermissionEnum;


class WarehouseCellsRelationManager extends RelationManager
{
    protected static string $relationship = 'cells';

    protected static ?string $title = 'Ячейки';

    protected static ?string $recordTitleAttribute = 'number';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return auth()->user()->can(UserPermissionEnum::WarehouseCellView->value);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Статус')
                    ->sortable()
                    ->badge(),

                TextColumn::make('number')
                    ->label('Номер ячейки')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('price')
                    ->label('Цена')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label('Символьный код')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('floor')
                    ->label('Этаж')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('row')
                    ->label('Ряд')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('section')
                    ->label('Секция')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('level')
                    ->label('Уровень')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('length')
                    ->label('Длинна, см')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('height')
                    ->label('Высота, см')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('width')
                    ->label('Ширина, см')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('volume')
                    ->label('Объем, см³')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновлена')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([])
            ->emptyStateHeading('Нет ячеек')
            ->emptyStateIcon('heroicon-o-rectangle-stack');
    }
}
