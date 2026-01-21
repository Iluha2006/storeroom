<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organization;
use App\Enums\OrganizationStatusEnum;
use App\Enums\OrganizationTypeEnum;


class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(OrganizationStatusEnum::class),
            'type' => $this->faker->randomElement(OrganizationTypeEnum::class),
            'name' => $this->faker->unique()->company(),
            'full_name' => $this->faker->unique()->company(),
            'inn' => $this->faker->numberBetween(1000000000, 999999999999),
            'kpp' => $this->faker->numberBetween(100000000, 999999999),
            'ogrn' => $this->faker->numberBetween(1000000000000, 999999999999999),
            'address' => $this->faker->address(),
            'phone' => $this->faker->unique()->e164PhoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function active(): OrganizationFactory
    {
        return $this->state(fn() => ['status' => OrganizationStatusEnum::Active]);
    }

    public function inactive(): OrganizationFactory
    {
        return $this->state(fn() => ['status' => OrganizationStatusEnum::Inactive]);
    }

    public function blocked(): OrganizationFactory
    {
        return $this->state(fn() => ['status' => OrganizationStatusEnum::Blocked]);
    }

    public function legal(): OrganizationFactory
    {
        return $this->state(fn() => ['type' => OrganizationTypeEnum::Legal]);
    }

    public function individual(): OrganizationFactory
    {
        return $this->state(fn() => ['type' => OrganizationTypeEnum::Individual]);
    }

    public function withName(string $name): OrganizationFactory
    {
        return $this->state(fn() => ['name' => $name]);
    }

    public function withFullName(string $fullName): OrganizationFactory
    {
        return $this->state(fn() => ['full_name' => $fullName]);
    }

    public function withInn(string $inn): OrganizationFactory
    {
        return $this->state(fn() => ['inn' => $inn]);
    }

    public function withKpp(string $kpp): OrganizationFactory
    {
        return $this->state(fn() => ['kpp' => $kpp]);
    }

    public function withOgrn(string $ogrn): OrganizationFactory
    {
        return $this->state(fn() => ['ogrn' => $ogrn]);
    }
}
