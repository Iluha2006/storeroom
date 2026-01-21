<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseObject;
use App\Models\Address;
use App\Models\Organization;

class WarehouseObjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Начинаю создавать объекты...');
        if (Address::count() === 0) {
            $this->call(AddressSeeder::class);
        }
        if (Organization::count() === 0) {
            $this->call(OrganizationSeeder::class);
        }
        $addresses = Address::all();
        $organizations = Organization::all();
        foreach ($addresses as $address) {
            WarehouseObject::factory()
                ->withAddress($address->id)
                ->withOrganization($organizations->random()->id)
                ->create();
        }
        $this->command->info('✓ Объекты успешно созданы');
    }
}
