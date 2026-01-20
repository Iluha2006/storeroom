<?php

namespace App\Filament\Resources\WarehouseObjects\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\WarehouseObjects\WarehouseObjectResource;


class CreateWarehouseObject extends CreateRecord
{
    protected static string $resource = WarehouseObjectResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
