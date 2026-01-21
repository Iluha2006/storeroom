<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;
use App\Models\Organization;
use App\Models\WarehouseObject;


class WarehouseObjectFactory extends Factory
{
    protected $model = WarehouseObject::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $slug = Str::slug($name);
        return [
            'uuid' => $this->faker->uuid(),
            'address_id' => Address::factory(),
            'organization_id' => Organization::factory(),
            'is_active' => $this->faker->boolean(),
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function active(): WarehouseObjectFactory
    {
        return $this->state(fn() => ['is_active' => true]);
    }

    public function inactive(): WarehouseObjectFactory
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function withAddress(int $addressId): WarehouseObjectFactory
    {
        return $this->state(fn() => ['address_id' => $addressId]);
    }

    public function withOrganization(int $organizationId): WarehouseObjectFactory
    {
        return $this->state(fn() => ['organization_id' => $organizationId]);
    }

    public function withName(string $name): WarehouseObjectFactory
    {
        return $this->state(fn() => ['name' => $name]);
    }

    public function withSlug(string $slug): WarehouseObjectFactory
    {
        return $this->state(fn() => ['slug' => $slug]);
    }

    public function withDescription(string $description): WarehouseObjectFactory
    {
        return $this->state(fn() => ['description' => $description]);
    }
}
