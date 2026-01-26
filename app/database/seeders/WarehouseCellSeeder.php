<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseCell;
use App\Models\WarehouseObject;

class WarehouseCellSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('только 20');
        if (WarehouseObject::count() === 0) {
            $this->call(WarehouseObjectSeeder::class);
        }

        $object = WarehouseObject::first();
        if (!$object) {
            $this->command->error('Ошибка');
            return;
        }

        WarehouseCell::factory(20)
            ->withObject($object->id)
            ->create();

        $this->command->info('Создано 20 ячеек');
    }
}
