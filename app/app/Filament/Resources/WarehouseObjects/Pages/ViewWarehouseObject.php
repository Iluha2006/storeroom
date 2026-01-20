<?php

namespace App\Filament\Resources\WarehouseObjects\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\WarehouseObjects\WarehouseObjectResource;


class ViewWarehouseObject extends ViewRecord
{
    protected static string $resource = WarehouseObjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}

