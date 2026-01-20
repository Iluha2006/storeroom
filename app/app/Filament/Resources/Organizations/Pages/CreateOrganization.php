<?php

namespace App\Filament\Resources\Organizations\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Organizations\OrganizationResource;


class CreateOrganization extends CreateRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
