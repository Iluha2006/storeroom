<?php

namespace App\Filament\Resources\Permissions\Pages;

use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Permissions\PermissionResource;


class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;
}
