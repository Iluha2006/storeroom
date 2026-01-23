<?php

declare(strict_types=1);

namespace App\Models;

use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\OneTimePasswords\Models\Concerns\HasOneTimePasswords;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;
use App\Enums\UserStatusEnum;
use Database\Factories\UserFactory;
use App\Enums\UserPermissionEnum;


class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_id',
        'status',
        'name',
        'lastname',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'remember_token',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'organization_id' => 'integer',
            'status' => UserStatusEnum::class,
            'email_verified_at' => 'immutable_datetime',
            'phone_verified_at' => 'immutable_datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'immutable_datetime',
            'last_login_at' => 'immutable_datetime',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function hasOrganization(): bool
    {
        return $this->organization_id !== null;
    }

    public function belongsToOrganization(int | Organization $organization): bool
    {
        $organizationId = $organization instanceof Organization ? $organization->id : $organization;
        return $this->organization_id === $organizationId;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Проверка статуса пользователя
        if ($this->status !== UserStatusEnum::Active) {
            return false;
        }

        // Проверка разрешения на доступ к админ-панели
        return $this->hasPermissionTo(UserPermissionEnum::AdminPanel->value);
    }
}
