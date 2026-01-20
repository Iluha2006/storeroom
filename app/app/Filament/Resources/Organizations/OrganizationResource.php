<?php

namespace App\Filament\Resources\Organizations;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Organization;
use App\Enums\UserPermissionEnum;
use App\Filament\Resources\Organizations\Pages\ListOrganizations;
use App\Filament\Resources\Organizations\Pages\CreateOrganization;
use App\Filament\Resources\Organizations\Pages\ViewOrganization;
use App\Filament\Resources\Organizations\Pages\EditOrganization;
use App\Filament\Resources\Organizations\Tables\OrganizationsTable;
use App\Filament\Resources\Organizations\Schemas\OrganizationForm;
use App\Filament\Resources\Organizations\Schemas\OrganizationInfolist;
use App\Filament\Resources\Organizations\RelationManagers\UsersRelationManager;


class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $slug = 'organizations';

    protected static string | null | \BackedEnum $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Организации';

    protected static ?string $modelLabel = 'Организация';

    protected static ?string $pluralModelLabel = 'Организации';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrganizationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationsTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizations::route('/'),
            'create' => CreateOrganization::route('/create'),
            'view' => ViewOrganization::route('/{record}'),
            'edit' => EditOrganization::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        return $count > 100 ? 'warning' : 'primary';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can(UserPermissionEnum::OrganizationView->value);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'full_name', 'email', 'inn', 'kpp', 'ogrn'];
    }
}
