<?php

namespace Database\Factories;

use App\Models\WarehouseCell;
use App\Models\WarehouseObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Enums\WarehouseCellStatusEnum;


class WarehouseCellFactory extends Factory
{
    protected $model = WarehouseCell::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 1000),
            'uuid' => $this->faker->uuid(),
            'warehouse_object_id' => WarehouseObject::factory(),
            'status' => $this->faker->randomElement(WarehouseCellStatusEnum::class),
            'slug' => $this->faker->slug(),
            'floor' => $this->faker->randomNumber(),
            'row' => $this->faker->randomNumber(),
            'section' => $this->faker->randomNumber(),
            'level' => $this->faker->randomNumber(),
            'number' => $this->faker->randomNumber(),
            'length' => $this->faker->randomNumber(),
            'height' => $this->faker->randomNumber(),
            'width' => $this->faker->randomNumber(),
            'volume' => $this->faker->randomNumber(),
            'price' => $this->faker->randomNumber(),
            'how_to_get_there' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
