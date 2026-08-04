<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\City;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю русские адреса с координатами...');

        if (City::count() === 0) {
            $this->call(CitySeeder::class);
        }

        $addresses = [
            [
                'city_slug' => 'moskva',
                'street' => 'ул. Нижние Поля',
                'house' => '8',
                'building' => '1',
                'frame' => null,
                'lat' => 55.66666500,
                'lon' => 37.75132300,
                'how_to_get_there' => 'Съезд с МКАД на Капотню, далее прямо до проходной склада.',
            ],
            [
                'city_slug' => 'klin',
                'street' => 'ул. Транспортная',
                'house' => '5',
                'building' => null,
                'frame' => null,
                'lat' => 56.32958000,
                'lon' => 36.72294300,
                'how_to_get_there' => 'С Ленинградского шоссе повернуть на ул. Транспортную, въезд через КПП №2.',
            ],
            [
                'city_slug' => 'tver',
                'street' => 'Октябрьский проспект',
                'house' => '50',
                'building' => null,
                'frame' => null,
                'lat' => 56.85964600,
                'lon' => 35.94374800,
                'how_to_get_there' => 'По Октябрьскому проспекту до развязки с ул. Склизкова, склад с правой стороны за заправкой.',
            ],
        ];

        foreach ($addresses as $data) {
            $city = City::where('slug', $data['city_slug'])->firstOrFail();
            unset($data['city_slug']);

            $slug = Str::slug(implode(' ', array_filter([
                $data['street'],
                $data['house'],
                $data['building'],
                $data['frame'],
            ])));

            Address::updateOrCreate(
                [
                    'city_id' => $city->id,
                    'street' => $data['street'],
                    'house' => $data['house'],
                    'building' => $data['building'],
                    'frame' => $data['frame'],
                ],
                [
                    'is_active' => true,
                    'slug' => $slug,
                    'lat' => $data['lat'],
                    'lon' => $data['lon'],
                    'how_to_get_there' => $data['how_to_get_there'],
                ]
            );
        }

        $this->command->info('✓ 3 русских адреса с координатами созданы');
    }
}
