<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать адреса...');
        if (City::count() === 0) {
            $this->call(CitySeeder::class);
        }
        $cities = City::all();
        foreach ($cities as $city) {
            Address::factory()
                ->count(20)
                ->withCity($city->id)
                ->create();
        }
        $this->command->info('✓ Адреса успешно созданы');
    }
}
