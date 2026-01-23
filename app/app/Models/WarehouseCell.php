<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Traits\HasFiles;
use App\Enums\WarehouseCellStatusEnum;
use App\Enums\FileCollectionEnum;


class WarehouseCell extends Model
{
    use HasFactory, HasFiles, SoftDeletes;

    protected $fillable = [
        'warehouse_object_id',
        'status',
        'slug',
        'floor',
        'row',
        'section',
        'level',
        'number',
        'length',
        'height',
        'width',
        'volume',
        'price',
        'how_to_get_there',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'status' => WarehouseCellStatusEnum::class,
            'slug' => 'string',
            'floor' => 'integer',
            'row' => 'integer',
            'section' => 'integer',
            'level' => 'integer',
            'number' => 'integer',
            'length' => 'integer',
            'height' => 'integer',
            'width' => 'integer',
            'volume' => 'integer',
            'price' => 'double:2',
            'how_to_get_there' => 'string',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
        ];
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo(WarehouseObject::class, 'warehouse_object_id');
    }

    public function address(): HasOneThrough | Address
    {
        return $this->hasOneThrough(
            Address::class,
            WarehouseObject::class,
            'id',
            'id',
            'warehouse_object_id',
            'address_id'
        );
    }

    public function organization(): HasOneThrough | Organization
    {
        return $this->hasOneThrough(
            Organization::class,
            WarehouseObject::class,
            'id',
            'id',
            'warehouse_object_id',
            'organization_id'
        );
    }

    /**
     * Получить план помещения
     */
    public function getPlanAttribute(): File | null
    {
        return $this->getFirstFile(FileCollectionEnum::Plans)->first();
    }

    /**
     * Получить все фотографии
     */
    public function getPhotosAttribute(): Collection
    {
        return $this->getFiles(FileCollectionEnum::Photos)->get();
    }

    /**
     * Объем в м³
     */
    public function getVolumeCubicMetersAttribute(): float
    {
        return round($this->volume / 1000000, 2);
    }

    /**
     * Форматированная цена
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2, ',', ' ') . ' ₽';
    }

    public function getFullAddressAttribute(): string
    {
        return $this->address?->full_address ?? 'Адрес не указан';
    }

    public function getFullAddressWithCityAttribute(): string
    {
        $address = $this->address;
        if (!$address) {
            return 'Адрес не указан';
        }

        $cityName = $address->city?->name;
        return ($cityName ? $cityName . ', ' : '') . $address->full_address;
    }

    public function getDimensionsAttribute(): string
    {
        return sprintf('%d×%d×%d см', $this->length, $this->width, $this->height);
    }
}
