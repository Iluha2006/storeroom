<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'hash' => $this->faker->word(),
            'disk' => $this->faker->word(),
            'path' => $this->faker->word(),
            'name' => $this->faker->name(),
            'filename' => $this->faker->word(),
            'original_name' => $this->faker->name(),
            'extension' => $this->faker->word(),
            'mime_type' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'width' => $this->faker->randomNumber(),
            'height' => $this->faker->randomNumber(),
            'order' => $this->faker->randomNumber(),
            'fileable_type' => $this->faker->word(),
            'fileable_id' => $this->faker->randomNumber(),
            'collection' => $this->faker->word(),
            'metadata' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
