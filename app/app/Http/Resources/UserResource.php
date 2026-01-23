<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Enums\UserPermissionEnum;


/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->getLabel(),
            ],
            'name' => $this->name,
            'lastname' => $this->lastname,
            'full_name' => trim("{$this->name} {$this->lastname}"),
            'email' => $this->email,
            'is_email_verified' => $this->email_verified_at !== null,
            'phone' => $this->phone,
            'is_phone_verified' => $this->phone_verified_at !== null,
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
            'roles' => $this->when(
                $request->user()?->hasPermissionTo(UserPermissionEnum::UserRoleView),
                fn() => $this->roles->pluck('name')
            ),
            'permissions' => $this->when(
                $request->user()?->hasPermissionTo(UserPermissionEnum::UserPermissionView),
                fn() => $this->getAllPermissions()->pluck('name')
            ),
            'last_login_at' => $this->last_login_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
