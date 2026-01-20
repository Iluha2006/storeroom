<?php

namespace App\Filament\Resources\WarehouseCells\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\WarehouseCells\WarehouseCellResource;


class ListWarehouseCells extends ListRecords
{
    protected static string $resource = WarehouseCellResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
