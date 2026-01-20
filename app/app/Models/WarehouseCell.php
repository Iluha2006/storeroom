<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
     * Вычисляемый объем в см³
     */
    public function getVolumeAttribute(): int
    {
        return $this->length * $this->height * $this->width;
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
}
