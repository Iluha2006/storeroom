<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Organization;
use App\Models\WarehouseObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WarehouseObjectFactory extends Factory
{
    protected $model = WarehouseObject::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 1000),
            'uuid' => $this->faker->uuid(),
            'address_id' => Address::factory(),
            'organization_id' => Organization::factory(),
            'is_active' => $this->faker->boolean(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
