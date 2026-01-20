<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;


class Organization extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'type',
        'name',
        'full_name',
        'inn',
        'kpp',
        'ogrn',
        'address',
        'phone',
        'email',
    ];

    /**
     * The attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'status' => OrganizationStatusEnum::class,
            'type' => OrganizationTypeEnum::class,
            'name' => 'string',
            'full_name' => 'string',
            'inn' => 'string',
            'kpp' => 'string',
            'ogrn' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'email' => 'string',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
        ];
    }

    /**
     * Пользователи организации
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Проверка, активна ли организация
     */
    public function isActive(): bool
    {
        return $this->status === OrganizationStatusEnum::Active;
    }

    /**
     * Проверка, заблокирована ли организация
     */
    public function isBlocked(): bool
    {
        return $this->status === OrganizationStatusEnum::Blocked;
    }

    /**
     * Проверка, является ли организация юридическим лицом
     */
    public function isLegal(): bool
    {
        return $this->type === OrganizationTypeEnum::Legal;
    }

    /**
     * Проверка, является ли организация ИП
     */
    public function isIndividual(): bool
    {
        return $this->type === OrganizationTypeEnum::Individual;
    }

    /**
     * Scope для фильтрации активных организаций
     */
    public function scopeActive($query)
    {
        return $query->where('status', OrganizationStatusEnum::Active);
    }

    /**
     * Scope для фильтрации по типу
     */
    public function scopeOfType($query, OrganizationTypeEnum $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope для поиска по ИНН
     */
    public function scopeByInn($query, string $inn)
    {
        return $query->where('inn', $inn);
    }

    /**
     * Получить краткое название для отображения
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Получить полное название для отображения
     */
    public function getFullDisplayNameAttribute(): string
    {
        return $this->full_name ?: $this->name;
    }
}
