<?php

namespace App\Filament\Resources\WarehouseObjects\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\WarehouseObjects\WarehouseObjectResource;


class ListWarehouseObjects extends ListRecords
{
    protected static string $resource = WarehouseObjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
