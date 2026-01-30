<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\Organization;
use App\Models\WarehouseObject;

class WarehouseObjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю 3 объекта складов...');

        if (Address::count() === 0) {
            $this->call(AddressSeeder::class);
        }
        if (Organization::count() === 0) {
            $this->call(OrganizationSeeder::class);
        }

        $addresses = Address::where('is_active', true)->get();
        $organizations = Organization::all();

        for ($i = 0; $i < 3; $i++) {
            WarehouseObject::factory()
                ->withAddress($addresses[$i]->id)
                ->withOrganization($organizations[$i]->id)
                ->active()
                ->create();
        }

        $this->command->info('✓ 3 объекта созданы (по одному на каждый адрес)');
    }
}