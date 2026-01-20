<?php

namespace App\Filament\Resources\Addresses;

use App\Filament\Resources\Addresses\Schemas\AddressForm;
use App\Filament\Resources\Addresses\Schemas\AddressInfolist;
use App\Filament\Resources\Addresses\Tables\AddressesTable;
use App\Models\Address;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Addresses\Pages\ListAddresses;
use App\Filament\Resources\Addresses\Pages\CreateAddress;
use App\Filament\Resources\Addresses\Pages\ViewAddress;
use App\Filament\Resources\Addresses\Pages\EditAddress;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserPermissionEnum;
use App\Filament\Resources\Addresses\RelationManagers\CityRelationManager;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $slug = 'addresses';

    protected static string | null | \BackedEnum $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Адреса';

    protected static ?string $modelLabel = 'Адрес';

    protected static ?string $pluralModelLabel = 'Адреса';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AddressForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AddressInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddressesTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            CityRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAddresses::route('/'),
            'create' => CreateAddress::route('/create'),
            'view' => ViewAddress::route('/{record}'),
            'edit' => EditAddress::route('/{record}/edit'),
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
     * @return Builder<Address>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['city']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'city.name'];
    }

    /**
     * @param Address $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->city) {
            $details['City'] = $record->city->name;
        }

        return $details;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can(UserPermissionEnum::AddressViewAny->value);
    }
}
