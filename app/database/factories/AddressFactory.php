<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\City;
use App\Models\Address;


class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $street = $this->faker->streetName();
        $house = $this->faker->randomDigit();
        $building = $this->faker->buildingNumber();
        $frame = $this->faker->randomDigit();
        $address = implode(' ', array_filter([$street, $house, $building, $frame]));
        $slug = Str::slug($address);
        return [
            'uuid' => $this->faker->uuid(),
            'city_id' => City::factory(),
            'is_active' => $this->faker->boolean(),
            'slug' => $slug,
            'street' => $street,
            'house' => $house,
            'building' => $building,
            'frame' => $frame,
            'lat' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
            'how_to_get_there' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withCity(int $cityId): AddressFactory
    {
        return $this->state(fn() => ['city_id' => $cityId]);
    }

    public function active(): AddressFactory
    {
        return $this->state(fn() => ['is_active' => true]);
    }

    public function inactive(): AddressFactory
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function withStreet(string $street): AddressFactory
    {
        return $this->state(fn() => ['street' => $street]);
    }

    public function withHouse(int $house): AddressFactory
    {
        return $this->state(fn() => ['house' => $house]);
    }

    public function withBuilding(int $building): AddressFactory
    {
        return $this->state(fn() => ['building' => $building]);
    }

    public function withoutBuilding(): AddressFactory
    {
        return $this->state(fn() => ['building' => null]);
    }

    public function withFrame(int $frame): AddressFactory
    {
        return $this->state(fn() => ['frame' => $frame]);
    }

    public function withoutFrame(): AddressFactory
    {
        return $this->state(fn() => ['frame' => null]);
    }

    public function withLat(float $lat): AddressFactory
    {
        return $this->state(fn() => ['lat' => $lat]);
    }

    public function withLon(float $lon): AddressFactory
    {
        return $this->state(fn() => ['lon' => $lon]);
    }
}
