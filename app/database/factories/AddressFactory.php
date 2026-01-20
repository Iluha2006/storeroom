<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 1000),
            'uuid' => $this->faker->uuid(),
            'city_id' => City::factory(),
            'is_active' => $this->faker->boolean(),
            'slug' => $this->faker->slug(),
            'street' => $this->faker->streetName(),
            'house' => $this->faker->randomDigitNotNull(),
            'building' => $this->faker->buildingNumber(),
            'frame' => $this->faker->randomDigit(),
            'lat' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
            'how_to_get_there' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
