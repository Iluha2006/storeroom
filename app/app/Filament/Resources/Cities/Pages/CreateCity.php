<?php

namespace App\Filament\Resources\Cities\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Cities\CityResource;


class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
