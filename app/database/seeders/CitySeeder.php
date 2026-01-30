<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю 3 города...');

        City::factory()->create(['name' => 'Москва', 'slug' => 'moskva', 'is_active' => true]);
        City::factory()->create(['name' => 'Клин', 'slug' => 'klin', 'is_active' => true]);
        City::factory()->create(['name' => 'Тверь', 'slug' => 'tver', 'is_active' => true]);

        $this->command->info('✓ 3 города успешно созданы');
    }
}