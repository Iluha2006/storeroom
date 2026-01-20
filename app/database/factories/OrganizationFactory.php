<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
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
            'name' => $this->faker->name(),
            'full_name' => $this->faker->name(),
            'inn' => $this->faker->numberBetween(1000000000, 999999999999),
            'kpp' => $this->faker->numberBetween(100000000, 999999999),
            'ogrn' => $this->faker->numberBetween(1000000000000, 999999999999999),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
