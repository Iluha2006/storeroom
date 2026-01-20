<?php

namespace App\Filament\Resources\WarehouseCells\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\WarehouseCells\WarehouseCellResource;


class ViewWarehouseCell extends ViewRecord
{
    protected static string $resource = WarehouseCellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}

