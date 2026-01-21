<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WarehouseCell;
use App\Models\WarehouseObject;
use App\Enums\WarehouseCellStatusEnum;


class WarehouseCellFactory extends Factory
{
    protected $model = WarehouseCell::class;

    public function definition(): array
    {
        $floor = $this->faker->randomNumber(2);
        $row = $this->faker->randomNumber(2);
        $section = $this->faker->randomNumber(2);
        $level = $this->faker->randomNumber(2);
        $number = $this->faker->randomNumber(4);
        $slug = implode('-', array_filter([$floor, $row, $section, $level, $number]));
        return [
            'uuid' => $this->faker->uuid(),
            'warehouse_object_id' => WarehouseObject::factory(),
            'status' => $this->faker->randomElement(WarehouseCellStatusEnum::class),
            'slug' => $slug,
            'floor' => $floor,
            'row' => $row,
            'section' => $section,
            'level' => $level,
            'number' => $number,
            'length' => $this->faker->randomDigitNotNull(),
            'height' => $this->faker->randomDigitNotNull(),
            'width' => $this->faker->randomDigitNotNull(),
            'price' => $this->faker->randomNumber(5),
            'how_to_get_there' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function available(): WarehouseCellFactory
    {
        return $this->state(fn() => ['status' => WarehouseCellStatusEnum::Available]);
    }

    public function reserved(): WarehouseCellFactory
    {
        return $this->state(fn() => ['status' => WarehouseCellStatusEnum::Reserved]);
    }

    public function unavailable(): WarehouseCellFactory
    {
        return $this->state(fn() => ['status' => WarehouseCellStatusEnum::Unavailable]);
    }

    public function withObject(int $objectId): WarehouseCellFactory
    {
        return $this->state(fn() => ['warehouse_object_id' => $objectId]);
    }

    public function withNumber(int $number): static
    {
        return $this->state(fn() => ['number' => $number]);
    }

    public function withPrice(int $price): WarehouseCellFactory
    {
        return $this->state(fn() => ['price' => $price]);
    }

    public function withoutFloor(): WarehouseCellFactory
    {
        return $this->state(fn() => ['floor' => null]);
    }

    public function withoutRow(): WarehouseCellFactory
    {
        return $this->state(fn() => ['row' => null]);
    }

    public function withoutSection(): WarehouseCellFactory
    {
        return $this->state(fn() => ['section' => null]);
    }

    public function withoutLevel(): WarehouseCellFactory
    {
        return $this->state(fn() => ['level' => null]);
    }
}
