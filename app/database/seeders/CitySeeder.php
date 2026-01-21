<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать города...');
        City::factory(20)->create();
        $this->command->info('✓ Города успешно созданы');
    }
}
