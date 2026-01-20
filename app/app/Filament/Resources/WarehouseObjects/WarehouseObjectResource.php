<?php

namespace App\Filament\Resources\WarehouseObjects;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\WarehouseObject;
use App\Enums\UserPermissionEnum;
use App\Filament\Resources\WarehouseObjects\Pages\ListWarehouseObjects;
use App\Filament\Resources\WarehouseObjects\Pages\CreateWarehouseObject;
use App\Filament\Resources\WarehouseObjects\Pages\ViewWarehouseObject;
use App\Filament\Resources\WarehouseObjects\Pages\EditWarehouseObject;
use App\Filament\Resources\WarehouseObjects\Tables\WarehouseObjectsTable;
use App\Filament\Resources\WarehouseObjects\Schemas\WarehouseObjectForm;
use App\Filament\Resources\WarehouseObjects\Schemas\WarehouseObjectInfolist;
use App\Filament\Resources\WarehouseObjects\RelationManagers\WarehouseCellsRelationManager;


class WarehouseObjectResource extends Resource
{
    protected static ?string $model = WarehouseObject::class;

    protected static ?string $slug = 'warehouse-objects';

    protected static string | null | \BackedEnum $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Объекты';

    protected static ?string $modelLabel = 'Объект';

    protected static ?string $pluralModelLabel = 'Объекты';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return WarehouseObjectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WarehouseObjectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarehouseObjectsTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            WarehouseCellsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWarehouseObjects::route('/'),
            'create' => CreateWarehouseObject::route('/create'),
            'view' => ViewWarehouseObject::route('/{record}'),
            'edit' => EditWarehouseObject::route('/{record}/edit'),
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
     * @return Builder<WarehouseObject>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['organization']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'organization.name'];
    }

    /**
     * @param WarehouseObject $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->organization) {
            $details['Organization'] = $record->organization->name;
        }

        return $details;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can(UserPermissionEnum::WarehouseObjectView->value);
    }
}
