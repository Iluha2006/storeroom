<?php

namespace App\Models;

use App\Enums\WarehouseCellStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class WarehouseObject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'organization_id',
        'is_active',
        'name',
        'slug',
        'description',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'address_id' => 'integer',
            'organization_id' => 'integer',
            'is_active' => 'boolean',
            'name' => 'string',
            'slug' => 'string',
            'description' => 'string',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
        ];
    }

    public function city(): HasOneThrough | City
    {
        return $this->hasOneThrough(
            City::class,
            Address::class,
            'id',
            'id',
            'address_id',
            'city_id'
        );
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function cells(): HasMany
    {
        return $this->hasMany(WarehouseCell::class);
    }



public function getAvailableCellsCountAttribute(): int
{
    return $this->cells()
        ->where('status', WarehouseCellStatusEnum::Available)
        ->count();
}

public function getPriceAttribute(): ?float
{
    return $this->cells()->min('price');
}

public function getCellsCountAttribute(): int
{
    return $this->cells()->count();
}
}
