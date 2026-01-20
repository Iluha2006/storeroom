<?php

namespace App\Filament\Resources\Permissions\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Permissions\PermissionResource;


class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;
}
