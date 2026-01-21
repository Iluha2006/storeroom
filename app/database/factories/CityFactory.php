<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\City;


class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        $city = $this->faker->unique()->city();
        $slug = Str::slug($city);
        return [
            'uuid' => $this->faker->uuid(),
            'is_active' => $this->faker->boolean(),
            'name' => $city,
            'slug' => $slug,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function active(): CityFactory
    {
        return $this->state(fn() => ['is_active' => true]);
    }

    public function inactive(): CityFactory
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function withName(string $name): CityFactory
    {
        return $this->state(fn() => ['name' => $name]);
    }

    public function withSlug(string $slug): CityFactory
    {
        return $this->state(fn() => ['slug' => $slug]);
    }
}
