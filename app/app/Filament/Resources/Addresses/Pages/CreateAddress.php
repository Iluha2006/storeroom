<?php

namespace App\Filament\Resources\Addresses\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Addresses\AddressResource;


class CreateAddress extends CreateRecord
{
    protected static string $resource = AddressResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
