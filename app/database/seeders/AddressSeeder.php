<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю 3 адреса (по одному на город)...');

        if (City::count() === 0) {
            $this->call(CitySeeder::class);
        }

        $cities = City::all();

        foreach ($cities as $city) {
            Address::factory()
                ->withCity($city->id)
                ->active()
                ->create();
        }

        $this->command->info('✓ 3 адреса созданы (по одному на каждый город)');
    }
}