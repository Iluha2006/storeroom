<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\City;
use App\Models\Organization;
use App\Models\WarehouseCell;
use App\Models\WarehouseObject;

class WarehouseObjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю русские объекты складов...');

        if (City::count() === 0) {
            $this->call(CitySeeder::class);
        }
        if (Address::count() === 0) {
            $this->call(AddressSeeder::class);
        }
        if (Organization::count() === 0) {
            $this->call(OrganizationSeeder::class);
        }

        $objects = [
            [
                'name' => 'Склад «Москва-Юг»',
                'slug' => 'sklad-moskva',
                'city_slug' => 'moskva',
                'street' => 'ул. Нижние Поля',
                'house' => '8',
                'organization_inn' => '7712345678',
                'description' => 'Современный складской комплекс класса B+ на юго-востоке Москвы. Охраняемая территория, видеонаблюдение, собственный парк погрузчиков.',
            ],
            [
                'name' => 'Логистический комплекс «Клин»',
                'slug' => 'logistika-klin',
                'city_slug' => 'klin',
                'street' => 'ул. Транспортная',
                'house' => '5',
                'organization_inn' => '5020044567',
                'description' => 'Тёплый склад в Клинском районе Московской области. Удобный подъезд с трассы М-11, круглосуточный режим работы.',
            ],
            [
                'name' => 'Складской терминал «Тверь»',
                'slug' => 'tver-terminal',
                'city_slug' => 'tver',
                'street' => 'Октябрьский проспект',
                'house' => '50',
                'organization_inn' => '6950012345',
                'description' => 'Крупный складской терминал в Твери. Высокие потолки, антипылевые полы, развитая логистическая инфраструктура.',
            ],
        ];

        $newSlugs = array_column($objects, 'slug');

        foreach ($objects as $data) {
            $city = City::where('slug', $data['city_slug'])->firstOrFail();
            $address = Address::where('city_id', $city->id)
                ->where('street', $data['street'])
                ->where('house', $data['house'])
                ->firstOrFail();
            $organization = Organization::where('inn', $data['organization_inn'])->firstOrFail();

            WarehouseObject::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'address_id' => $address->id,
                    'organization_id' => $organization->id,
                    'is_active' => true,
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]
            );
        }

        $this->cleanupOldObjects($newSlugs);

        $this->command->info('✓ 3 русских объекта складов созданы');
    }

    private function cleanupOldObjects(array $keepSlugs): void
    {
        $oldObjects = WarehouseObject::whereNotIn('slug', $keepSlugs)->get();

        foreach ($oldObjects as $object) {
            WarehouseCell::where('warehouse_object_id', $object->id)->forceDelete();
            $object->forceDelete();
        }

        if ($oldObjects->isNotEmpty()) {
            $usedAddressIds = WarehouseObject::withTrashed()->pluck('address_id');
            Address::whereNotIn('id', $usedAddressIds)->forceDelete();
        }
    }
}
