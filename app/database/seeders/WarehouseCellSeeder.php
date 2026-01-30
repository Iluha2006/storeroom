<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WarehouseObject;
use App\Models\WarehouseCell;
use App\Enums\WarehouseCellStatusEnum;

class WarehouseCellSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn('Создаю 3 ячейки для объектов...');

        if (WarehouseObject::count() === 0) {
            $this->call(WarehouseObjectSeeder::class);
        }

        $objects = WarehouseObject::where('is_active', true)->get();

        foreach ($objects as $object) {
            WarehouseCell::factory()
                ->withObject($object->id)
                ->state(['status' => WarehouseCellStatusEnum::Available->value])
                ->create();
        }

        $this->command->info('✓ 3 ячейки созданы (по одной на каждый объект)');
    }
}