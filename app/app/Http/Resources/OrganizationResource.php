<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Organization;


/** @mixin Organization */
class OrganizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->getLabel(),
            ],
            'type' => [
                'value' => $this->type->value,
                'label' => $this->type->getLabel(),
            ],
            'name' => $this->name,
            'full_name' => $this->full_name,
            'requisites' => [
                'inn' => $this->inn,
                'kpp' => $this->kpp,
                'ogrn' => $this->ogrn,
            ],
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'users_count' => $this->whenCounted('users'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
