<?php

namespace App\Filament\Resources\WarehouseCells;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\WarehouseCell;
use App\Enums\UserPermissionEnum;
use App\Filament\Resources\WarehouseCells\Schemas\WarehouseCellForm;
use App\Filament\Resources\WarehouseCells\Schemas\WarehouseCellInfolist;
use App\Filament\Resources\WarehouseCells\Tables\WarehouseCellsTable;
use App\Filament\Resources\WarehouseCells\Pages\ListWarehouseCells;
use App\Filament\Resources\WarehouseCells\Pages\CreateWarehouseCell;
use App\Filament\Resources\WarehouseCells\Pages\EditWarehouseCell;
use App\Filament\Resources\WarehouseCells\Pages\ViewWarehouseCell;


class WarehouseCellResource extends Resource
{
    protected static ?string $model = WarehouseCell::class;

    protected static ?string $slug = 'warehouse-cells';

    protected static string | null | \BackedEnum $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ячейки';

    protected static ?string $modelLabel = 'Ячейка';

    protected static ?string $pluralModelLabel = 'Ячейки';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return WarehouseCellForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WarehouseCellInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarehouseCellsTable::table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWarehouseCells::route('/'),
            'create' => CreateWarehouseCell::route('/create'),
            'view' => ViewWarehouseCell::route('/{record}'),
            'edit' => EditWarehouseCell::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * @return Builder<WarehouseCell>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['object']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['slug', 'object.name'];
    }

    /**
     * @param WarehouseCell $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->object) {
            $details['Object'] = $record->object->name;
        }

        return $details;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can(UserPermissionEnum::WarehouseCellView->value);
    }
}
