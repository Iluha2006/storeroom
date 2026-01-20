<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'is_active',
        'slug',
        'street',
        'house',
        'building',
        'frame',
        'lat',
        'lon',
        'how_to_get_there',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'is_active' => 'boolean',
            'slug' => 'string',
            'street' => 'string',
            'house' => 'string',
            'building' => 'string',
            'frame' => 'string',
            'lat' => 'float',
            'lon' => 'float',
            'how_to_get_there' => 'string',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
            'deleted_at' => 'immutable_datetime',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = [
            $this->street,
            $this->house ? "д. {$this->house}" : null,
            $this->building ? "стр. {$this->building}" : null,
            $this->frame ? "корп. {$this->frame}" : null,
        ];

        return implode(', ', array_filter($parts));
    }
}
