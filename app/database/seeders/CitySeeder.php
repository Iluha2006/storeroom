<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю русские города...');

        $cities = [
            ['name' => 'Москва', 'slug' => 'moskva'],
            ['name' => 'Клин', 'slug' => 'klin'],
            ['name' => 'Тверь', 'slug' => 'tver'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['slug' => $city['slug']],
                ['name' => $city['name'], 'is_active' => true]
            );
        }

        $this->command->info('✓ 3 русских города успешно созданы');
    }
}
